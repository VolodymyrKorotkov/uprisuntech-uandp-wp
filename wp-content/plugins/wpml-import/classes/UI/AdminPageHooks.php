<?php

namespace WPML\Import\UI;

use WPML\FP\Wrapper;
use WPML\Import\Commands\Provider;
use WPML\Import\Helper\ImportedItems;
use WPML\Import\Helper\Resources;
use WPML\FP\Str;
use WPML\LIB\WP\Hooks;
use function WPML\Container\make;
use function WPML\FP\spreadArgs;

class AdminPageHooks implements \IWPML_Backend_Action {

	const PAGE_SLUG = WPML_IMPORT_ADMIN_PAGE_SLUG;

	const CONTEXT = 'gui';

	public function add_hooks() {
		Hooks::onAction( 'wpml_admin_menu_configure' )
			->then( [ self::class, 'registerSubMenu' ] );

		Hooks::onAction( 'admin_enqueue_scripts' )
			->then( spreadArgs( [ self::class, 'enqueueApp' ] ) );
	}

	/**
	 * @return void
	 */
	public static function registerSubMenu() {
		do_action( 'wpml_admin_menu_register_item', [
			'capability' => 'wpml_manage_languages',
			'menu_slug'  => self::PAGE_SLUG,
			'menu_title' => __( 'Export and Import', 'wpml-import' ),
			'page_title' => self::getTitle(),
			'function'   => [ self::class, 'render' ],
		] );
	}

	/**
	 * @return void
	 */
	public static function render() {
		?>
		<div class="wrap wrap-wpml-import">
			<h1><?php echo esc_html( self::getTitle() ); ?></h1>
			<div id="wpml-import-app"></div>
		</div>
		<?php
	}

	/**
	 * @return string
	 */
	private static function getTitle() {
		return __( 'WPML Export and Import', 'wpml-import' );
	}

	/**
	 * @param string $hook
	 *
	 * @return void
	 */
	public static function enqueueApp( $hook ) {
		if ( Str::endsWith( self::PAGE_SLUG, $hook ) ) {
			Wrapper::of( self::getData() )->map( Resources::enqueueApp( 'import' ) );
		}
	}

	/**
	 * @return array
	 */
	private static function getData() {
		$importedItems = make( ImportedItems::class );

		return [
			'name' => 'wpmlImport',
			'data' => [
				'endpoints'          => [
					'command' => Endpoints\Command::class,
				],
				'commands'           => self::getCommandsData(),
				'importedPostsCount' => $importedItems->countPosts(),
				'importedTermsCount' => $importedItems->countTerms(),
				'exampleData'        => make( ExampleData::class )->get(),
			],
		];
	}

	/**
	 * @return array
	 */
	private static function getCommandsData() {
		return wpml_collect( Provider::get( self::CONTEXT ) )
			->map( function( $className ) {
				/** @var class-string<\WPML\Import\Commands\Base\Command> $className */

				return [
					Endpoints\Command::KEY_COMMAND_CLASS => $className,
					'title'                              => $className::getTitle(),
					'description'                        => $className::getDescription(),
				];
			} )
			->toArray();
	}
}

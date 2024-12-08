(function () {
    let registerBlockType = wp.blocks.registerBlockType
    let TextControl = wp.components.TextControl
    let RichText = wp.editor.RichText

    registerBlockType('custom/newsletter-block', {
        title: 'Newsletter Block',
        icon: 'email',
        category: 'common',
        attributes: {
            title: {
                type: 'string',
                default: 'Join the community!'
            },
            text: {
                type: 'string',
                default: 'Get the latest news and exclusive offers. Subscribe now with your phone or email. Stay connected, stay informed.'
            },
            buttonText: {
                type: 'string',
                default: 'Subscribe to newsletter'
            }
        },
        edit: function (props) {
            let attributes = props.attributes

            function updateTitle (newTitle) {
                props.setAttributes({ title: newTitle })
            }

            function updateText (newText) {
                props.setAttributes({ text: newText })
            }

            function updateButtonText (newText) {
                props.setAttributes({ buttonText: newText })
            }

            return wp.element.createElement(
                'div',
                { className: 'for-newsletter' },
                wp.element.createElement(
                    'div',
                    { className: 'wrap' },
                    wp.element.createElement(
                        'h3',
                        { className: 'title-section' },
                        wp.element.createElement(RichText, {
                            tagName: 'h3',
                            value: attributes.title,
                            onChange: updateTitle
                        })
                    ),
                    wp.element.createElement(
                        'div',
                        { className: 'text-sm' },
                        wp.element.createElement(RichText, {
                            tagName: 'div',
                            value: attributes.text,
                            onChange: updateText
                        })
                    ),
                    wp.element.createElement(
                        'div',
                        { className: 'btn btn_bg_primary' },
                        wp.element.createElement(RichText, {
                            tagName: 'div',
                            value: attributes.buttonText,
                            onChange: updateButtonText
                        })
                    )
                )
            )
        },
        save: function (props) {
            const { title, text, buttonText } = props.attributes

            return wp.element.createElement(
                'div',
                { className: 'for-newsletter' },
                wp.element.createElement(
                    'div',
                    { className: 'wrap' },
                    wp.element.createElement(
                        'h3',
                        { className: 'title-section' },
                        title
                    ),
                    wp.element.createElement(
                        'div',
                        { className: 'text-sm' },
                        text
                    ),
                    wp.element.createElement(
                        'div',
                        { className: 'btn btn_bg_primary' },
                        buttonText
                    )
                )
            )
        }

    })

})()

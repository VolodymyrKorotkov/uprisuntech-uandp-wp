(function () {
    var registerBlockType = wp.blocks.registerBlockType
    var Button = wp.components.Button
    var MediaUpload = wp.blockEditor.MediaUpload
    var TextControl = wp.components.TextControl
    var RichText = wp.editor.RichText

    registerBlockType('custom/download-block', {
        title: 'Download Block',
        icon: 'download',
        category: 'common',
        attributes: {
            items: {
                type: 'array',
                default: []
            }
        },
        edit: function (props) {
            var items = props.attributes.items

            // Функция для добавления нового элемента
            function addItem () {
                var newItems = items.slice()
                newItems.push({ imgSrc: '', title: '', info: '' })
                props.setAttributes({ items: newItems })
            }

            function updateItem (newItem, index) {
                var newItems = items.slice()
                newItems[index] = newItem
                props.setAttributes({ items: newItems })
            }

            return wp.element.createElement(
                'div',
                { className: 'download' },
                wp.element.createElement(
                    'ul',
                    { className: 'download__list' },
                    items.map(function (item, index) {
                        return wp.element.createElement(
                            'li',
                            { className: 'download__item', key: index },
                            wp.element.createElement(MediaUpload, {
                                onSelect: function (media) {
                                    updateItem(Object.assign({}, item, { imgSrc: media.url }), index)
                                },
                                type: 'image', // Set media type to image
                                value: item.imgSrc ? item.imgSrc : '',
                                render: function ({ open }) {
                                    return wp.element.createElement(
                                        'a',
                                        { href: '#', className: 'download__img', onClick: open },
                                        item.imgSrc ? wp.element.createElement('img', {
                                            src: item.imgSrc,
                                            alt: '',
                                            className: 'download__img'
                                        }) : 'Upload Image'
                                    )
                                }
                            }),
                            wp.element.createElement(TextControl, {
                                className: 'download__title',
                                value: item.title || '',
                                onChange: function (newTitle) {
                                    updateItem(Object.assign({}, item, { title: newTitle }), index)
                                }
                            }),
                            wp.element.createElement(
                                'div',
                                { className: 'download__info' },
                                item.info
                            )
                        )
                    })
                ),
                // Кнопка для добавления нового элемента
                wp.element.createElement(Button, {
                    className: 'download__add-button',
                    onClick: addItem
                }, 'Add Item')
            )
        },
        save: function (props) {
            var items = props.attributes.items

            return wp.element.createElement(
                'div',
                { className: 'download' },
                wp.element.createElement(
                    'ul',
                    { className: 'download__list' },
                    items.map(function (item, index) {
                        return wp.element.createElement(
                            'li',
                            { className: 'download__item', key: index },
                            wp.element.createElement(
                                'a',
                                { href: '#', className: 'download__img' },
                                item.imgSrc ? wp.element.createElement('img', {
                                    src: item.imgSrc,
                                    alt: '',
                                    className: 'download__img'
                                }) : ''
                            ),
                            wp.element.createElement('a', {
                                href: '#',
                                className: 'download__title',
                                dangerouslySetInnerHTML: { __html: item.title || '' }
                            }),
                            wp.element.createElement(
                                'div',
                                {
                                    className: 'download__info',
                                    dangerouslySetInnerHTML: {
                                        __html: item.info
                                    }
                                }
                            )
                        )
                    })
                )
            )
        }
    })
})()

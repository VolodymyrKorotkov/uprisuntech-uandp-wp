(function () {
    var registerBlockType = wp.blocks.registerBlockType
    var TextControl = wp.components.TextControl
    var RichText = wp.editor.RichText

    registerBlockType('custom/download-block', {
        title: 'Download Block',
        icon: 'download',
        category: 'common',
        attributes: {
            items: {
                type: 'array',
                default: [
                    {
                        imgSrc: '',
                        title: 'All_Solar_Companies.pdf',
                        info: '2.45 MB'
                    },
                    {
                        imgSrc: '',
                        title: 'All_Solar_Companies.pdf',
                        info: '2.45 MB'
                    },
                    {
                        imgSrc: '',
                        title: 'All_Solar_Companies.pdf',
                        info: '2.45 MB'
                    }
                ]
            }
        },
        edit: function (props) {
            var items = props.attributes.items

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
                            wp.element.createElement(
                                'a',
                                { href: '#', className: 'download__img' },
                                wp.element.createElement('img', {
                                    src: item.imgSrc,
                                    alt: '',
                                    className: 'download__img'
                                })
                            ),
                            wp.element.createElement(RichText, {
                                tagName: 'a',
                                className: 'download__title',
                                value: item.title,
                                onChange: function (newTitle) {
                                    return updateItem(Object.assign({}, item, { title: newTitle }), index)
                                }
                            }),
                            wp.element.createElement(
                                'div',
                                { className: 'download__info' },
                                wp.element.createElement(RichText, {
                                    tagName: 'div',
                                    value: item.info,
                                    onChange: function (newInfo) {
                                        return updateItem(Object.assign({}, item, { info: newInfo }), index)
                                    }
                                })
                            )
                        )
                    })
                )
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
                                wp.element.createElement('img', {
                                    src: item.imgSrc,
                                    alt: '',
                                    className: 'download__img'
                                })
                            ),
                            wp.element.createElement('a', {
                                href: '#',
                                className: 'download__title',
                                dangerouslySetInnerHTML: { __html: item.title }
                            }),
                            wp.element.createElement(
                                'div',
                                { className: 'download__info', dangerouslySetInnerHTML: { __html: item.info } }
                            )
                        )
                    })
                )
            )
        }
    })

})()

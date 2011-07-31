/**
 * Class for displaying a window to add a news
 * @class Extzf.view.news.AddNewsWindow
 */
Ext.define('Extzf.view.news.AddNewsWindow', {
   
    extend: 'Ext.window.Window',

    id: 'extzf-addnewswindow',
    alias: 'widget.extzf_core_addnewswindow',
    
    title: Extzf.tr('Add news'),
    
    width: 600,
    height: 560,
    resizable: false,
    constrain: true,

    layout: {
        type: 'fit'
    },
    
    store: null,
    
    
    /**
     * Render the viewport of the news management tab
     * @return void
     */
    initComponent: function() {
        
        this.items = this.buildItems();
        
        // Call parent contructor
        this.callParent(arguments);
        
        Extzf.debug("Init add news window");
    },
    
    
    /**
     * Builds the items to add to this.items
     * @return {Array}
     */
    buildItems: function() {
        
        var me = this;
        
        return [{
            xtype: 'form',
            id: 'extzf-news-createeditorform',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            bodyStyle: 'padding: 5px',
            items: [{
                xtype: 'hidden',
                name: 'id',
                allowBlank: false
            }, {
                fieldLabel: Extzf.tr('Title'),
                xtype: 'textfield',
                name: 'title',
                allowBlank: false
            }, {
                fieldLabel: Extzf.tr('Text'),
                xtype: 'htmleditor',
                name: 'text',
                height: 458,
                allowBlank: false
            }],
            bbar: ['->', {
                id: 'extzf-addnews-savebtn',
                text: Extzf.tr('Save')
            }]
        }];
    }
});

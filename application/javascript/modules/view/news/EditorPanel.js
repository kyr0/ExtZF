/**
 * Class for displaying the module panel
 * @class Extzf.view.news.EditorPanel
 */
Ext.define('Extzf.view.news.EditorPanel', {
   
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.extzf_news_editorpanel',
    
    id: 'extzf-news-editorpanel',
    
    title: Extzf.tr('News editor'),
    
    
    /**
     * Render the viewport of the news editor
     * @return void
     */
    initComponent: function() {
        
        this.items = this.buildItems();
        
        // Call parent contructor
        this.callParent(arguments);
        
        Extzf.debug("Init news editor");
    },
    
    
    /**
     * Builds the editor instance itself
     * @return void
     */
    buildItems: function() {
        
        return [{
            xtype: 'form',
            id: 'extzf-news-editorform',
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
            bbar: [{
                text: Extzf.tr('Update'),
                id: 'extzf-news-editorpanel-panelbtn'
            }]
        }];
    }
});

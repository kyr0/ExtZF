/**
 * @class Extzf.view.news.Viewport News module viewport class
 * @extends Ext.container.Container
 */
Ext.define('Extzf.view.news.Viewport', {
    
    extend: 'Ext.container.Container',
    alias: 'widget.extzf_manage_viewport',
    
    layout: 'border',
    
    
    /**
     * Render the viewport of the news module
     * @return void
     */
    initComponent: function() {
        
        this.items = this.buildItems();
        
        // Call parent contructor
        this.callParent(arguments);
        
        Extzf.debug("Init news viewport");
    },
    
    
    /**
     * Builds the items to add to this.items
     * @return {Array}
     */
    buildItems: function() {
        
        //  xtype: 'extzf_news_editorpanel'
        return [{
            region: 'west',
            width: 230,
            xtype: 'extzf_news_gridpanel'
        }, {
            region: 'center',
            xtype: 'container',
            id: 'extzf-news-editorcontainer'
        }];
    }
});
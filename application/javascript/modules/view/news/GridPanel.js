/**
 * Class for displaying the module panel
 * @class Extzf.view.news.GridPanel
 */
Ext.define('Extzf.view.news.GridPanel', {
   
    extend: 'Ext.grid.Panel',
    
    alias: 'widget.extzf_news_gridpanel',
    
    id: 'extzf-news-gridpanel',
    split: true,
    
    title: Extzf.tr('News'),

    store: null,
    
    
    /**
     * Render the viewport of the news grid
     * @return void
     */
    initComponent: function() {
        
        this.store = Ext.create('Extzf.store.core.News', {
            autoLoad: true,
            id: 'extzf-core-adminnewsstore'
        });
        
        this.columns = [
            {text: Extzf.tr('Title'), dataIndex: 'title', flex: 1},
            {text: Extzf.tr('Publish time'), dataIndex: 'timestamp', renderer: this.renderPublishDate, width: 120}
        ];
        
        this.bbar = [{
            text: Extzf.tr('Reload'),
            id: 'extzf-news-gridpanel-reloadbtn'
        }, {
            text: Extzf.tr('Add'),
            id: 'extzf-news-gridpanel-addbtn'
        }, {
            text: Extzf.tr('Remove'),
            id: 'extzf-news-gridpanel-removebtn'
        }];
        
        // Call parent contructor
        this.callParent(arguments);
        
        Extzf.debug("Init news grid");
    },
    
    
    /**
     * Renders the publish date column
     * @param {Object} dateObj
     * @return {String}
     */
    renderPublishDate: function(dateObj) {
        return dateObj.date;
    }
});

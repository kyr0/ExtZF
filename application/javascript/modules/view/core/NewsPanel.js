/**
 * Class for displaying the news panel
 * @class Extzf.view.core.NewsPanel
 */
Ext.define('Extzf.view.core.NewsPanel', {
   
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.extzf-core-newspanel',
    xtype: 'panel',
    split: true,
    
    id: 'extzf-newspanel',

    layout: {
        type: 'card'
    },
    region: 'center',
    
    title: Extzf.tr('News'),
    
    
    /**
     * Render the news panel
     * @return void
     */
    initComponent: function() {
        
        var me = this;
        
        Extzf.debug("Init news panel");
        
        this.items = [];
        
        this.tools = [{
            type: 'refresh',
            qtip: Extzf.tr('Refresh news'),
            handler: function() {
                me.onNewsRefresh.call(me); 
            }
        }];
        
        // Call parent contructor
        this.callParent(arguments);
        
        // On render, load news
        this.listeners = {
            render: this.loadNews
        };
    },
    
    
    /**
     * Builds loaded news
     * @param {Object} news
     * @return void
     */
    buildNews: function(news) {
        
        Extzf.log('Building news');
        
        Ext.getCmp('extzf-newspanel').removeAll();
        
        // Build a panel for each news
        var newsPanelInstance = null;
        for (var i=0; i<news.length; i++) {
            newsPanelInstance = Ext.create("Ext.panel.Panel", news[i]);
            Ext.getCmp('extzf-newspanel').add(newsPanelInstance);
        }
        Ext.getCmp('extzf-newspanel').down('panel').expand();
    },
    
    
    /**
     * Loads the news to display as panel inside
     * the accordion layout
     * @return void
     */
    loadNews: function() {
        
        Extzf.log('Loading news...');
        
        var me = this;
        
        var newsStore = Ext.create('Extzf.store.core.News');
        newsStore.load({
            callback: function() {
                
                Extzf.log('Success: New store load');
                Extzf.debug(newsCount);
                
                var news = [];
                var newsCount = newsStore.getCount();
                var allNewsRecords = newsStore.getRange(0, newsCount);
                
                var curNewsData = {};
                for (var i=0; i<newsCount; i++) {
                    curNewsData = allNewsRecords[i].data;
                    news.push({
                        html: curNewsData.text,
                        title: '<b>' + curNewsData.title + '</b> | ' + curNewsData.timestamp.date,
                        flex: 1 / newsCount,
                        bodyStyle: 'padding: 5px'
                    });
                }
                me.buildNews(news);
            }
        });
    },
    
    
    /**
     * Refreshes the news
     * @return void
     */
    onNewsRefresh: function() {
        Extzf.log('Clicked refresh news');
        this.loadNews();
    },
    
    
    bbar: [{
        disabled: true,
        text: Extzf.tr('Newer'),
        id: 'extzf-core-newsprevbtn'
    }, '->', {
        id: 'extzf-core-newsnextbtn',
        text: Extzf.tr('Older')
    }]
});

/**
 * @class Extzf.controller.News News controller
 */
Ext.define('Extzf.controller.News', {
    extend: 'Ext.app.Controller',

    addNewsWindow: null,

    /**
     * Initialiizes the controller
     * @return void
     */
    init: function() {
        
        var me = this;
        Extzf.log('Initialized News Controller');
        
        // Controls the news grid
        me.controlNewsGrid();
    },
    
    
    /**
     * Controls the news grid
     * @return void
     */
    controlNewsGrid: function() {
        
        var me = this;

        // Control the UI component events
        me.control({

           '#extzf-news-gridpanel': {
               'itemclick': me.onNewsItemClick
           },
           
           '#extzf-news-gridpanel-reloadbtn': {
               'click': function() {
                   var store = Ext.data.StoreManager.get('extzf-core-adminnewsstore');
                   store.load();
               }
           },
           
           '#extzf-news-gridpanel-addbtn': {
               'click': function() {

                   if (me.addNewsWindow == null) {
                       me.addNewsWindow = Ext.create('Extzf.view.news.AddNewsWindow', {
                           renderTo: Ext.getCmp('viewport').getEl(),
                           resizable: false
                       });
                   }
                   me.addNewsWindow.show();
               }
           },

           '#extzf-news-gridpanel-removebtn': {
               'click': me.onRemoveBtnClick
           },

           '#extzf-addnews-savebtn': {
               'click': me.onAddNewsSaveBtnClick
           }
        });
    },


    /**
     * Gets called when a user clicks on the "Save"
     * button in the "Add a news" window
     * @return void
     */
    onAddNewsSaveBtnClick: function() {
        var newNews = Ext.getCmp('extzf-news-createeditorform').getForm().getValues();

        var newsRecord = Ext.create('Extzf.model.News');
        newsRecord.set('title', newNews.title);
        newsRecord.set('text', newNews.text);

        newsRecord.save();

        setTimeout(function() {

            // Reload the admin store
            var store = Ext.data.StoreManager.get('extzf-core-adminnewsstore');
            store.load();

            // Also reload the news viewer panel
            Ext.getCmp('extzf-newspanel').loadNews();

        }, 500);

        Ext.getCmp('extzf-addnewswindow').hide();
    },


    /**
     * Gets called if someone clicks on the remove button
     * @return void
     */
    onRemoveBtnClick: function() {

        var sm = Ext.getCmp('extzf-news-gridpanel').getSelectionModel();
        var selectedResources = sm.getSelection();

        if (selectedResources.length > 0) {
            var selectedResource = selectedResources[0];

             var result = Ext.Msg.confirm(Extzf.tr('Please confirm'), Extzf.tr('Are you sure to delete this news permanently?'), function(btn, text) {

                 if (btn == "yes") {

                     Extzf.debug("Really remove news");

                     var resourceStore = Ext.data.StoreManager.get('extzf-core-adminnewsstore');
                     resourceStore.remove(selectedResource);
                     resourceStore.sync();

                     // Clear a possible open editor screen
                     Ext.getCmp('extzf-news-editorcontainer').removeAll();
                 }
             });

         } else {
             Ext.Msg.alert(Extzf.tr('Warning'), Extzf.tr('Please select a (only one) news.'));
         }
   },
    
    
    /**
     * Loads editor if clicked on a news record
     * @param {Object} cmp
     * @param {Object} record
     * @return void
     */
    onNewsItemClick: function(cmp, record) {
        
        Extzf.log('clicked on item');
        var me = this;
        
        // Remove all from container and add editor form
        var newsContainer = Ext.getCmp('extzf-news-editorcontainer');
        newsContainer.removeAll();
        
        var newsEditor = Ext.create('Extzf.view.news.EditorPanel', {
            listeners: {
                render: function() {
                    Ext.getCmp('extzf-news-editorform').getForm().loadRecord(record);
                    me.controlNewsEditor();
                }
            }
        });
        newsContainer.add(newsEditor);
    },
    
    
    /**
     * Controls the editor form
     * @return void
     */
    controlNewsEditor: function() {
        
        var me = this;
        
        me.control({
            '#extzf-news-editorpanel-panelbtn': {
                'click': me.onNewsEditorUpdateClick
            }
        });
    },
    
    
    /**
     * Updates the record if clicked on editor update button
     * @return void
     */
    onNewsEditorUpdateClick: function() {
        
        var newsRecord = Ext.getCmp('extzf-news-editorform').getForm().getValues();
        var store = Ext.data.StoreManager.get('extzf-core-adminnewsstore');
        
        // Updated data
        var storeNewsRecord = store.getById(parseInt(newsRecord.id));
        
        // Set updated data
        storeNewsRecord.set('title', newsRecord.title);
        storeNewsRecord.set('text', newsRecord.text);

        // Synchronize the store and afterwards
        // reload the news viewer panel
        store.sync();

        setTimeout(function() {
            
            // Reload the news viewer panel
            Ext.getCmp('extzf-newspanel').loadNews();
        }, 500)
    }
});
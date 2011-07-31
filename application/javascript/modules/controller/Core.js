/**
 * @class Extzf.controller.Core Core controller
 */
Ext.define('Extzf.controller.Core', {
    extend: 'Ext.app.Controller',

    
    /**
     * Initializes the controller
     * @return void
     */
    init: function() {

        var me = this;
        Extzf.log('Initialized Core Controller');

        // Control the header UI components
        me.controlHeaderToolbar();

        // Controls the news UI components
        me.controlNewsPagination();
    },
    

    /**
     * Contains calls to control the header button actions
     * @return void
     */
    controlHeaderToolbar: function() {
        
        var me = this;
        
        me.control({
            '#extzf-manage-news-btn': {
                click: function() {

                    // Create the news management window
                    var manageNewsWindow = Ext.create('Ext.window.Window', {
                        resizable: true,
                        width: 930,
                        title: Extzf.tr('News administration'),
                        height: 595,
                        layout: 'fit',
                        items: [{
                            xtype: 'extzf_manage_viewport'
                        }]
                    });

                    // Load the controller for the view
                    Extzf.loadController('News');

                    // Show the window
                    manageNewsWindow.show();
                }
            }
        });
    },


    /**
     * Controls the news pagination
     * @return void
     */
    controlNewsPagination: function() {

        var me = this;
        me.control({

            '#extzf-core-newsprevbtn': {
                click: me.onNewsPaginationPrevClick
            },

            '#extzf-core-newsnextbtn': {
                click: me.onNewsPaginationNextClick
            }
        })
    },


    /**
     * Gets called when the user clicks on "Newer" in the
     * news view.
     * @return void
     */
    onNewsPaginationPrevClick: function() {

        Ext.getCmp('extzf-newspanel').getLayout().prev();

        Ext.getCmp('extzf-core-newsnextbtn').enable();
        if (Ext.getCmp('extzf-newspanel').getLayout().getPrev()) {
            Ext.getCmp('extzf-core-newsprevbtn').enable();
        } else {
            Ext.getCmp('extzf-core-newsprevbtn').disable();
        }

    },


    /**
     * Gets called when the user clicks on "Older" in the
     * news view.
     * @return void
     */
    onNewsPaginationNextClick: function() {

        Ext.getCmp('extzf-newspanel').getLayout().next();

        Ext.getCmp('extzf-core-newsprevbtn').enable();
        if (Ext.getCmp('extzf-newspanel').getLayout().getNext()) {
            Ext.getCmp('extzf-core-newsnextbtn').enable();
        } else {
            Ext.getCmp('extzf-core-newsnextbtn').disable();
        }
    }
});
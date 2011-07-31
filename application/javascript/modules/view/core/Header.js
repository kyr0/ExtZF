/**
 * Class for displaying the header section
 * @class Extzf.view.core.Header
 */
Ext.define('Extzf.view.core.Header', {
    
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.extzf_core_header',
    
    id: 'extzf-header',
    height: 100,
    region: 'north',
    
    // Logo placement
    items: [{
        html: '<div width="100%" height="100%" style="background-color:#494949;"> '
             +'<center><img src="/assets/header/header.png" '
             +'height="72px" width="406px" /></center></div>'
    }],
    frame: false,

    bbar: [{
        id: 'extzf-manage-news-btn',
        text: Extzf.tr('Manage news')
    }]
});

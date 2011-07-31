Ext.define('Extzf.model.News', {
    
    extend: 'Ext.data.Model',
    
    // News entity fields
    fields: ['id', 'title', 'text', {name: 'timestamp', datatype: 'date'}, 'authorUserId'],
    
    idProperty: 'id',
    
    // Proxy communication
    proxy: {
        type: 'direct',
        api: {
            read: Direct.core.NewsController.directread,
            update: Direct.core.NewsController.directupdate,
            create: Direct.core.NewsController.directcreate,
            destroy: Direct.core.NewsController.directdestroy
        },
        reader: {
            root: 'data',
            totalProperty: 'total'
        }
    }
});

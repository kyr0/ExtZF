// Translation object
Extzf.i18n = {
    trErrorOccurted:  '<?php echo $this->tr("Direct_Error") ?>',
    loadMaskMsg: '<?php echo $this->tr("Ext_Loading") ?>'
};

// Translate the Direct error messages
Extzf.trCls(Extzf.Direct, {
    trErrorOccurted: Extzf.i18n.trErrorOccurted
});

// Ext language
Extzf.trCls(Ext.LoadMask, {
    msg: Extzf.i18n.loadMaskMsg
});
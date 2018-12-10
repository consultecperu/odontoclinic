export default {
    data() {
        return {
            notificacion : {
                message:'',
                title:'Notificación del Sistema',
                icon:'la la-thumbs-up',
                url:'#',
                target:'_blank'
            },
            type:'success',     // danger -- warning -- success
            from:'top',
            align:'right',
            time:1000 
        }

    },
    methods: {
        notificaciones: function(emessage,eicon,etype){
            this.notificacion.message = emessage
            this.notificacion.icon = eicon
            this.type = etype
            $.notify(this.notificacion,{
                type: this.type,
                placement: {
                    from: this.from,
                    align: this.align
                },
                z_index:999999,
                time: this.time,
            });            
        },
        showSearch: function(cols){
            let f = 0
            for(f=0;f<cols.length;f++)
            {
                if(cols[f].filterOptions != undefined ){
                    cols[f].filterOptions.enabled = !cols[f].filterOptions.enabled 
                }

            }            
        },
        showToolTips: function(){
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })             
        }       
    }
}
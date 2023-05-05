function deleteOne(param) {
   return axios.delete(param).then(
      res => {
         if(res.data > 0){
         
            swal({
               text: 'Supprimé !',
               type: 'success',
               buttons : {
                  confirm: {
                        className : 'btn btn-success btn-sm'
                  }
               }
            });
            return true;
         }else{
            swal("Erreur !", "", {
               icon : "error",
               buttons: {        			
                  confirm: {
                     className : 'btn btn-danger btn-sm'
                  }
               },
         });
         return false;
      }
   });
}

function informer(info){
   swal("", info, {
      icon : "info",
      buttons: {        			
         confirm: {
            className : 'btn btn-info btn-sm'
         }
      },
   });
}

function deleteAll(tab,url) {
   return axios.post(url,{data: tab}).then(
      res => {
         if(res.data > 0){
            swal({
               text: 'Supprimé !',
               type: 'success',
               buttons : {
                  confirm: {
                        className : 'btn btn-success btn-sm'
                  }
               }
            });
            return true;
         }else{
            swal("Erreur!", "", {
               icon : "error",
               buttons: {        			
                  confirm: {
                     className : 'btn btn-danger btn-sm'
                  }
               },
         });
         return false;
      }
   });
}

async function supression(param) {
return swal({
      text: "Etes vous sûr !",
      type: 'warning',
         buttons:{
            confirm: {
               text : 'Oui',
               className : 'btn btn-success btn-sm'
            },
            cancel: {
                text : 'Annuler',
               visible: true,
               className: 'btn btn-danger btn-sm'
            }
      }
   }).then((Delete) => {
      if (Delete) {
         return deleteOne(param);
      } else {
            swal.close();
            return false;
      }
   });
}

async function supressionAll(param,url) {
return swal({
      title: '',
      text: "Etes-vous sûr ?",
      type: 'warning',
         buttons:{
            confirm: {
               text : 'Oui',
               className : 'btn btn-success btn-sm'
            },
            cancel: {
                text : 'Annuler',
               visible: true,
               className: 'btn btn-danger btn-sm'
            }
      }
   }).then((Delete) => {
      if (Delete) {
         return deleteAll(param,url);
      } else {
         swal.close();
         return false;
      }
   });
}





function reussie(){
   swal("", "Operation reussie !", {
      icon : "success",
      buttons: {        			
         confirm: {
            className : 'btn btn-success btn-sm'
         }
      },
   });
}

export {supression,supressionAll,informer, reussie};
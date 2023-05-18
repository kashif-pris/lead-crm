
      function haveReadIt(bookId,userID){
        $(".library_"+bookId).attr('disabled',true);
        $(".library_"+bookId).html('<i class="fa fa-spinner fa-spin"></i>Loading');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          "url":"/book/addToLibrary/"+bookId,
          "method":"POST",
          "data":{'bookId':bookId,'userID':userID},
          success: function(resp){
            if(resp == "0"){
              $(".library_"+bookId).attr('disabled',false);
              $(".library_"+bookId).html('Have Read It');
              alert("Login is required to add book to library");
            }else if(resp == "1"){
              $(".library_"+bookId).attr('class','library_'+bookId+' btn btn-success');
              $(".library_"+bookId).html('Have Read It');
              $(".library_"+bookId).attr('disabled',false);
           
              $(".wishlist_"+bookId).html('Will Read It');
              $(".wishlist_"+bookId).attr('class','wishlist_'+bookId+' btn btn-primary');
            }
            // alert('Type= Library, '+' Book ID= '+bookId + ', User Id= ' +userID);
          },
          error: function(){
            alert('something went wrong. Please try it later.');
          }
        });
      }

      function willReadIt(bookId,userID){
        $(".wishlist_"+bookId).attr('disabled',true);
        $(".wishlist_"+bookId).html('<i class="fa fa-spinner fa-spin"></i>Loading');
        // alert('Type= Wishlist, '+' Book ID= '+bookId + ', User Id= ' +userID);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          "url":"/book/addToWishlist/"+bookId,
          "method":"POST",
          "data":{'bookId':bookId,'userID':userID},
          success: function(resp){
            if(resp == "0"){
              alert("Login is required to add book to library");
              $(".wishlist_"+bookId).attr('disabled',false);
              $(".wishlist_"+bookId).html('Will Read It');
            
            }else if(resp == "1"){
              $(".wishlist_"+bookId).attr('class','wishlist_'+bookId+' btn btn-success');
              $(".wishlist_"+bookId).html('Will Read It');
              $(".wishlist_"+bookId).attr('disabled',false);
              
              $(".library_"+bookId).attr('class','library_'+bookId+' btn btn-primary');
            }
            // alert('Type= Library, '+' Book ID= '+bookId + ', User Id= ' +userID);
          },
          error: function(){
            alert('something went wrong. Please try it later.');
          }
        });
      }
      function addToFollowerList(follower_id,created_by){
          if(created_by == ''){
                alert('Login is required to add to follower list');
            return false;
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            "url":"/author/FollowerList",
            "method":"POST",
            "data":{'follower_id':follower_id,'created_by':created_by},
            success: function(resp){
              if(resp == "0"){
                alert("Removed from Follower List");
                $(".author_"+follower_id).html('Follow');
                $(".author_"+follower_id).attr('class','author_'+follower_id+' btn btn-primary');
              
              }else if(resp == "1"){
                $(".author_"+follower_id).attr('class','author_'+follower_id+' btn btn-danger');
                $(".author_"+follower_id).html('Following');
              }
            },
            error: function(){
              alert('something went wrong. Please try it later.');
            }
          });
      }

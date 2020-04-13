<div  id="pickup_location_modal" class="modal" tabindex="-1" role="dialog" style="z-index:9999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pickup Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="height:400px">
                <div id="pickup_location_map" style="height:100%"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_pickup_location_take_location">Take Location</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">    
    var pickupLocationMap;    
    var indonesiaCenter = {lat: -1.397, lng: 120.644};     
    var zoomLevel =5;    
    var pointerMarker;
    var callback;
    PickupLocation = {
        show:function(paramCallback,location,zoomLavel){
            $("#pickup_location_modal").modal("show");
            if (typeof location != "undefined"){
                indonesiaCenter = location;                 
            }
            if (typeof zoomLavel != "undefined"){
                zoomLevel = zoomLavel;            
            }else{
                zoomLevel = 5;
            }
            

            pickupLocationMap = new google.maps.Map(document.getElementById('pickup_location_map'), {
                center: indonesiaCenter,
                zoom: zoomLevel
            });
            



            pointerMarker = new google.maps.Marker({
                position: indonesiaCenter,
			    map: pickupLocationMap,
			    title: 'Center'
            });

            callback = paramCallback;

            pickupLocationMap.addListener('center_changed', function() {
                pointerMarker.setPosition(pickupLocationMap.getCenter());
                App.log(pickupLocationMap.getBounds().getNorthEast().toString());
                App.log(pickupLocationMap.getBounds().getSouthWest().toString());
            });
            
        },
        returnPos:function(){
            $("#pickup_location_modal").modal("hide");
            var position = pointerMarker.getPosition();
            callback(position,pickupLocationMap.getZoom());
            
        }
    }

    
    

    $(function(){
        $("#btn_pickup_location_take_location").click(function(e){
            e.preventDefault();
            PickupLocation.returnPos();
        });
    });



</script>
<!--
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALBylGkXyB-P1boXwMtz7oCV0L8-aHEBA"></script>
-->
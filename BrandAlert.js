
$(function() {
    
    $( document ).on( "click", '.brand_link', function() {
        
        var brandId = this.id.match(/\d+/)[0];
        var brandName = $(this).text();
      
        $.ajax({
            type: "GET",
            url: "AlertHandler.php",
            data: { brandId: brandId, action: "Alert" },
            success: function (response) {
                var data = $.parseJSON(response);
                $("#alert_table").empty();
                $("#alert_table").show();
                $("#alert_and_detail_content_header").html("Brand: " + brandName);   
                
                $("#alert_table").append(
                        "<tr>" +
                            "<th>Alert ID</th>" +
                            "<th>Date/Time</th>" +
                            "<th># Apps</th>" +
                         "</tr>"
                 );
                
                data.forEach(function(entry) {
                    
                    $("#alert_table").append(
                        "<tr>" + 
                            "<td><button type='button' id='alert_link_" + entry.alert_id + "' class='btn btn-link alert_link'>" + entry.alert_id + "</button></td>" +
                            "<td class='detail_date'>" + entry.run_date.replace(/-/g, '/') + "</td>" +
                            "<td>" + entry.total_apps + "</td>" +
                        "</tr>"
                    );
                    
                });
                
            },
            error: function (xhr) {
                alert("Could not load brand alert.");
            }
        });
      
    });
    
    $( document ).on( "click", '.alert_link', function() {
        
        var alertId = this.id.match(/\d+/)[0];
        var brandHeader = $("#alert_and_detail_content_header").text();
        var alertDate = $(this).closest('tr').find('.detail_date').text();
        
        $.ajax({
            type: "GET",
            url: "AlertHandler.php",
            data: { alertId: alertId, action: "AlertDetail" },
            success: function (response) {
                var data = $.parseJSON(response);
                
                $("#alert_table").empty();
                $("#alert_table").show();
                $("#alert_and_detail_content_header").html(brandHeader + "<br>" + "Date: " + alertDate);
                
                $("#alert_table").append(
                    "<tr>" +
                        "<th>App URL</th>" +
                        "<th>Status</th>" +
                    "</tr>"
                );
                                
                data.forEach(function(entry) {
                    var status = "Inactive";
                    if (parseInt(entry.status) === 1) {
                        status = "Active";
                    }
                    
                    $("#alert_table").append(
                        "<tr>" + 
                            "<td><a href='" + entry.app_url + "'>" + entry.app_url + "</td>" +
                            "<td>" + status + "</td>" +
                        "</tr>"
                    );
                    
                });
                
            },
            error: function (xhr) {
                alert("Could not load brand alert detail.");
            }
        });
        
    });
    
});

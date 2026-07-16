<script>
    function mark_notification_as_read($not_id)
    {
        $.ajax({
            url: "/supplier-panel/notifications/mark-as-read/" + $not_id,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr) {
                console.log(xhr);
            }
            
        });
    }
</script>
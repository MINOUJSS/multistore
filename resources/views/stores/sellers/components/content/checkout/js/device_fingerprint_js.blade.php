<script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
<script>
    FingerprintJS.load().then(fp => {
        fp.get().then(result => {
            document.querySelector('#device_fingerprint').value = result.visitorId;
        });
    });
</script>
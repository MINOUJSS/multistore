<script>
   function initDigitalFilePond(inputSelector, hiddenInputSelector) {
    const input = document.querySelector(inputSelector);

    if (!input) return;

    const pond = FilePond.create(input, {
        name: 'digital_file',
        allowMultiple: false,
        maxFiles: 1,
        maxParallelUploads: 1,
        chunkUploads: false,
        credits: false,
        acceptedFileTypes: [
            'application/pdf',
            'application/zip',
            'application/x-zip-compressed'
        ]
    });

    pond.setOptions({
        server: {
            process: {
                url: '/seller-panel/upload-temp',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                },

                onload: (response) => {
                    // let data = JSON.parse(response);

                    // document.querySelector(hiddenInputSelector).value =
                    //     data.id;
                    // return data.id;
                    try {
                            const data = JSON.parse(response);
                            document.querySelector(hiddenInputSelector).value = data.id;
                            return data.id;
                        } catch (e) {
                            console.error('Invalid response:', response);
                            throw e;
                        }
                },

                onerror: (response) => {
                    console.error(response);
                }
            },

            revert: (uniqueFileId, load, error) => {
                fetch('/seller-panel/upload-temp', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                    },
                    body: JSON.stringify({
                        id: uniqueFileId
                    })
                })
                .then(() => load())
                .catch(() => error());
            }
        }
    });

    return pond;
}
</script>
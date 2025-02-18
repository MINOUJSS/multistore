<script>
    let files=[],
    container=document.querySelector('.images_container'),
    input=document.getElementById('product_images');
    //
    input.addEventListener('change', () =>{
        let selectedFiles = Array.from(input.files); // Convert FileList to an array
        files.push(...selectedFiles); // Add new files to the files array
        showImages();
    })
    //
    const showImages = () =>{
        let images='';
        files.forEach((e, i) => {
             images += `
            <div class="image">
                <img src="${URL.createObjectURL(e)}" alt="image">
                <span onclick="delImage(${i})">&times;</span>
            </div>`;
        })
        container.innerHTML=images;
    }
    //delete image from dialog
    const delImage = index =>{
        files.splice(index,1)
        updateInputFiles(); // Update the input.files to match the modified files array
        showImages()
    }

    // Update the input.files to reflect the modified files array
    const updateInputFiles = () => {
        const dataTransfer = new DataTransfer(); // Create a new DataTransfer object
        files.forEach((file) => {
            dataTransfer.items.add(file); // Add each remaining file to the DataTransfer object
        });
        input.files = dataTransfer.files; // Update the input's FileList
    };
//functions
function browsdialogmultifile()
    {
        document.getElementById('product_images').click();
    }
 //delete image from database
function delImageData(id)
{
        $.ajax({
            type: 'DELETE',
            url:'/supplier-panel/product/image/delete/'+id,
            success: function(response){
                console.log(response);
                //afficher les images de produit
                let image_html='';
                response.product_images.forEach(e => {
                    image_html+=`<div class="image"><img src="${e.image_path}" alt="image"><span onclick="delImageData(${e.id})">&times</span></div>`;
                });
                $("#images_container").html(image_html);
            },
            error:function(xhr)
            {
                console.log(xhr.responseText);
            }
        });
        
}
</script>
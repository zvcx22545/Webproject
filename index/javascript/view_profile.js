// show Image
//for preview the profile image
const input = document.querySelector("#fileUpload");

input.addEventListener("change",preview);

function preview() {
    const fileobject  = this.files[0];
    const filereader = new FileReader();

    filereader.readAsDataURL(fileobject);

    filereader.onload = function() {
        const image_src = filereader.result;
        const image = document.querySelector("#profile_img");
        image.setAttribute('src',image_src);
        image.setAttribute('style','display:;');
    }
}
//for preview the post image

const input = document.querySelector("#select_post_img");
const locationinput = document.querySelector("#select_location_img");

if(input)
{
    input.addEventListener("change",preview);

function preview() {
    const fileobject  = this.files[0];
    const filereader = new FileReader();

    filereader.readAsDataURL(fileobject);

    filereader.onload = function() {
        const image_src = filereader.result;
        const image = document.querySelector("#post_img");
        image.setAttribute('src',image_src);
        image.setAttribute('style','display:;');
    }
}
}

if(locationinput)
{
    locationinput.addEventListener("change",preview2);

function preview2() {
    const fileobject  = this.files[0];
    const filereader = new FileReader();

    filereader.readAsDataURL(fileobject);

    filereader.onload = function() {
        const image_src = filereader.result;
        const image = document.querySelector("#location_img");
        image.setAttribute('src',image_src);
        image.setAttribute('style','display:;');
    }
}
}

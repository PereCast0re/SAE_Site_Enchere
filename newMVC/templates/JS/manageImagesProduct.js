document.addEventListener('DOMContentLoaded', () => {
    console.log("J'ai fini de charger !")
})

const images = document.querySelectorAll('.imgProduct');

images.forEach(image => {
    image.addEventListener('click', () => {
        let mainImg = document.querySelector('#mainImg');

        console.log(mainImg.src);
        console.log(image.src);

        let temp = mainImg.src;
        mainImg.src = image.src;
        image.src = temp;
    })
});

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

/////////// V2 ///////////

// const changeButton = document.querySelector('#changeImage');

// changeButton.addEventListener('click', () => {
//     console.log("Je change l'image");

//     const image1 = document.querySelector('#imgProduct1');
//     const image0 = document.querySelector('#imgProduct0');

//     console.log(image1)
//     console.log(image0)

//     // const linkImage1 = image1.dataset.linkImage1;
//     // const linkImage0 = image0.dataset.linkImage0;

//     console.log(linkImage1);
//     console.log(linkImage0);

//     // temp = image1.dataset.linkImage1;
//     // image1.dataset.linkImage1 = image0.dataset.linkImage0;
//     // image0.dataset.linkImage0 = temp;

//     temp = image1.src;
//     image1.src = image1.dataset.linkImage1;
//     image0.src = image0.dataset.linkImage0;
// })

/////////// V1 ///////////

// document.addEventListener('DOMContentLoaded', () => {
//     console.log("J'ai fini de charger !")
// })

// const changeButton = document.querySelector('#changeImage');

// changeButton.addEventListener('click', () => {
//     console.log("Je change l'image");

//     const image1 = document.querySelector('#imgProduct1');

//     console.log(image1)

//     const linkImage1 = image1.dataset.linkImage1;

//     console.log(linkImage1);

//     image1.dataset.linkImage1 = "./Annonce/test/test_0.jpg";

//     image1.src = image1.dataset.linkImage1;
// })
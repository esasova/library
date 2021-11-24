<template>
    <div class="mainBanner secondary--text d-flex justify-center align-center font-weight-bold font30 pa-2 text-center">
        Bienvenue sur le site de la médiathèque de Chapelle-Curreaux
    </div>
</template>
<style scoped lang="scss">
.mainBanner {
    background-image: url('~/assets/images/books.jpg');
    background-size: cover;
    height: 40vh;
}
@media screen and (min-width: 768px) {
    .mainBanner {
        height: 50vh;
        font-size: 70px;
    }
}
</style>

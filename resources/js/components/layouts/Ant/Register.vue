<template>
	 <div :style="myStyle" >
	    <a-card  :bordered="false" style="margin:auto; box-shadow: 0px 0px 30px 0px #666;border-radius: 5px;background-color: rgb(236, 238, 241);color: #ecf0f1;" class="col-4 col-s-4 col-x-3 col-l-3 col-sx-4 overlay" >
        <slot/>
	    </a-card>
	 </div>
</template>

<style type="text/css">
/* For mobile phones: */
[class*="col-"] {
  width: 100%;
}

@media only screen and (min-width: 481px) and (max-width: 1024px) and (orientation:landscape) {
  /* For landscape layouts only */
  .col-sx-1 {width: 8.33%;}
  .col-sx-2 {width: 16.66%;}
  .col-sx-3 {width: 25%;}
  .col-sx-4 {width: 33.33%;}
  .col-sx-5 {width: 41.66%;}
  .col-sx-6 {width: 50%;}
  .col-sx-7 {width: 58.33%;}
  .col-sx-8 {width: 66.66%;}
  .col-sx-9 {width: 75%;}
  .col-sx-10 {width: 83.33%;}
  .col-sx-11 {width: 91.66%;}
  .col-sx-12 {width: 100%;}
}

@media only screen and (min-width: 600px) {
  /* For tablets: */
  .col-s-1 {width: 8.33%;}
  .col-s-2 {width: 16.66%;}
  .col-s-3 {width: 25%;}
  .col-s-4 {width: 33.33%;}
  .col-s-5 {width: 41.66%;}
  .col-s-6 {width: 50%;}
  .col-s-7 {width: 58.33%;}
  .col-s-8 {width: 66.66%;}
  .col-s-9 {width: 75%;}
  .col-s-10 {width: 83.33%;}
  .col-s-11 {width: 91.66%;}
  .col-s-12 {width: 100%;}
}

@media only screen and (min-width: 768px) {
  /* For desktop: */
  .col-1 {width: 8.33%;}
  .col-2 {width: 16.66%;}
  .col-3 {width: 25%;}
  .col-4 {width: 33.33%;}
  .col-5 {width: 41.66%;}
  .col-6 {width: 50%;}
  .col-7 {width: 58.33%;}
  .col-8 {width: 66.66%;}
  .col-9 {width: 75%;}
  .col-10 {width: 83.33%;}
  .col-11 {width: 91.66%;}
  .col-12 {width: 100%;}
}

@media only screen and (min-width: 992px) {
  /* For desktop: */
  .col-x-1 {width: 8.33%;}
  .col-x-2 {width: 16.66%;}
  .col-x-3 {width: 25%;}
  .col-x-4 {width: 33.33%;}
  .col-x-5 {width: 41.66%;}
  .col-x-6 {width: 50%;}
  .col-x-7 {width: 58.33%;}
  .col-x-8 {width: 66.66%;}
  .col-x-9 {width: 75%;}
  .col-x-10 {width: 83.33%;}
  .col-x-11 {width: 91.66%;}
  .col-x-12 {width: 100%;}
}

@media only screen and (min-width: 1200px) {
  /* For desktop: */
  .col-l-1 {width: 8.33%;}
  .col-l-2 {width: 16.66%;}
  .col-l-3 {width: 25%;}
  .col-l-4 {width: 33.33%;}
  .col-l-5 {width: 41.66%;}
  .col-l-6 {width: 50%;}
  .col-l-7 {width: 58.33%;}
  .col-l-8 {width: 66.66%;}
  .col-l-9 {width: 75%;}
  .col-l-10 {width: 83.33%;}
  .col-l-11 {width: 91.66%;}
  .col-l-12 {width: 100%;}
}

.overlay {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 1;
}

</style>

<script>

export default {
  data() {
    return {
	    myStyle:{
	    	//backgroundColor:"#e2e2e5",
	    	height: "100%",
	    	width: "100%",
	    	paddingTop: "2%",
        paddingButton: "5%",
        left: "0",
        top: "0",
	    },
    };
  },
};
</script>
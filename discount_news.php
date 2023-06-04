<style>
    .scroll-left {
        height: 50px;	
        overflow: hidden;
        position: relative;
        background: #4fa2f9;  
        color: #ff2400;
        /* border: 1px solid orange; */
        font-weight: bold;
    }
    .scroll-left p {
        position: absolute;
        width: 100%;
        height: 100%;
        margin: 0;
        line-height: 50px;
        text-align: center;
        /* Starting position */
        transform:translateX(100%);
        /* Apply animation to this element */
        animation: scroll-left 15s linear infinite;
    }
    /* Move it (define the animation) */
    @keyframes scroll-left {
        0%   {
            transform: translateX(100%); 		
        }
        100% {
            transform: translateX(-100%); 
        }
    }
</style>

<div class="scroll-left">
    <p>10% discount available on all items, PROMO CODE: "Happy Eating" </p>
</div>
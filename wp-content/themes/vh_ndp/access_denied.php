
<?php


?>
<div class="access-denied-overlay"></div>
<div class="access-denied">
    <div class="close">
        <a class="href-to-main-close" href="/dashboard/">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </a>
    </div>
    <div class="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-diamond" viewBox="0 0 16 16">
            <path d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
             <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
        </svg>
    </div>
    
    <h2><?php _e('Access denied', 'ndp'); ?></h2>
    <p><?php _e('The Operator cannot create requests on the platform', 'ndp'); ?></p>
    <a class="href-to-main" href="/dashboard/"><?php _e('Okay', 'ndp'); ?></a>
</div>


<style>
.access-denied{
    width: 500px;
    height: 300px;
    max-width: 80%;
    padding: 20px;
    border-radius: 20px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background:#fff; 
    z-index: 100;
    display:flex;
    flex-direction: column;
    justify-content: space-between;
}
.access-denied .href-to-main {
    width: 100%;
    border-radius: 50px;
    padding: 10px 60px;
    background: #2A59BD;
    color:#fff;
    text-align:center;
}
.access-denied .close{
    display: flex;
    flex-direction: row-reverse;
}
.access-denied .alert{
    margin:20px;
}
.access-denied .alert svg{
    color:#B28207;
    width: 32px;
    height: 32px;
    box-shadow: 0 0 0px 20px #ECE1C4;
    background: #ECE1C4;
    border-radius: 100%;
}



.access-denied-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Здесь 0.5 - это прозрачность затемнения */
    z-index: 99; /* Убедитесь, что z-index выше, чем у всплывающего окна */
}

</style>
<div id="toast-container">
    <div id="error-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-exclamation-circle text-danger mr-2"></i>
            <strong class="mr-auto">Error</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?php
                $errorMessage = urldecode($_GET["error"]);
                echo $errorMessage;
            ?>
        </div>
    </div>
</div>
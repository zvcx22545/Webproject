
<style>
     #exampleFormControlTextarea1 {
        height: 150px !important;
    }
</style>
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title me-3">คุณอยากโพสต์อะไร</h5>
                <select id="categoryDropdown" class="form-control option-container text-center rounded-pill mt-1 w-50">
                    <option value="" disabled selected>หมวดหมู่</option>
                    <option value="clothing">Clothing</option>
                    <option value="travel">Travel</option>
                    <option value="food">Food</option>
                </select>
                
                <button type="button" class="btn-close mr-lg-2" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            
            <div class="modal-body">
                <img src="" style="display: none;" id="post_img" class="w-100 rounded border">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="my-3">

                        <input class="form-control" name="post_img" type="file" id="select_post_img">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea name="post" class="form-control h-50" id="exampleFormControlTextarea1" rows="1" placeholder = "คุณกำลังคิดอะไรอยู่"></textarea>
                    </div>


                    <button type="submit" class="btn btn-primary" id="post_button" value="Post">Post</button>

                </form>
            </div>

        </div>
    </div>
</div>
<script src="./javascript/custom.js?v=<?= time() ?>"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->

</body>

</html>
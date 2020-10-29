<?php include_once '../app/views/inc/navbar.php';?>
 

    <div class="container mt-5">

        <div class="row">

            <div id ="mainC" class="col-sm-12 col-md-9">
                <div id="vid-container">
                    <video id="video">Stream is not available ...</video>
                </div>

                <input type='file' class="btn btn-secondary" id="file" accept="image/*">
                <button id="btn" class="btn btn-primary">Upload Image</button>
                <div id="btns">
                    <button id="photo-button" class="btn btn-primary">Take a photo</button>
                    <select id="photo-filter">
                        <option value="none">Normal</option>
                        <option value="grayscale(100%)">Grayscale</option>
                        <option value="sepia(100%)">Sepia</option>
                        <option value="invert(100%)">Invert</option>
                    </select>
                    <button id="clear-button">Clear</button>
                </div>
                <div style="background-color:gray;height:150px;">
                    <img id="pharon" onclick="icon(this.id)" style="width:20%;height:100%;" alt="pharon" src="./images/stickers/pharon.png">
                    <img id="trump" onclick="icon(this.id)" style="width:20%;height:100%;" alt="trump" src="./images/stickers/trump.png">
                    <img id="beard" onclick="icon(this.id)" style="width:20%;height:100%;" alt="beard" src="./images/stickers/beard.png">
                    <img id="sunglasses" onclick="icon(this.id)" style="width:20%;height:100%;" alt="sunglasses" src="./images/stickers/sunglasses.png">
                </div>
            </div>
            

        <div class="col-sm-12 col-md-3 d-flex align-items-stretch" id="imgs">
        <div id="canvasDiv">
        <canvas style="width:100%;background-color:lightgray;"id="canvas"></canvas>
        </div>
        </div>
        
    </div>
    </div>

<?php include_once '../app/views/inc/footer.php'; ?>
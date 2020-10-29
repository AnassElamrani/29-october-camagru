var playload = window.location.hash.substr(1);
document.writeln(playload);

// Global vars
var arr = document.URL.split("/");
var controller = arr[arr.length - 1];
let stickerName;
let selectedImg;
// let tokenImgId;
let width = 500,
height = 0,
filter = 'none',
streaming = false;

// DOM Elements
let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let photos = document.getElementById('photos');
let photoButton = document.getElementById('photo-button');
let clearButton = document.getElementById('clear-button');
let photoFilter = document.getElementById('photo-filter');
let uploadImage = document.getElementById('upload-image');
const input = document.getElementById('file');
const button = document.getElementById('btn');
const vidDiv = document.getElementById('vid-container');
// let mainC = document.getElementById('mainC');
// let canvasDiv = document.getElementById('canvasDiv');
// let osheight = mainC.offsetHeight;
// canvasDiv.offsetHeight = osheight;
// console.log(osheight); 

if(photoButton){
  photoButton.disabled = true;
}
if(photoButton){
  button.disabled = true;
}
// var vidPosition = video.getBoundingClientRect();
// console.log(vidPosition);

// Get media Stream
if(controller == 'Montages'){
  navigator.mediaDevices.getUserMedia({video: true, audio: false}
    )
    .then(function(stream) {
      // Link to the video source
      video.srcObject = stream;
      // Play video
      video.play();
    })
    .catch(function(error) {
      console.log(`Error: ${err}`);
    });
    
    // Play when ready
    video.addEventListener('canplay', function(e) {
      if(!streaming) {
        // Set video / canvas height
        height = video.videoHeight / (video.videoHeight / width);

        // video.setAttribute('width', width);
        // video.setAttribute('height', height);
    // canvas.setAttribute('width', width);
    // canvas.setAttribute('height', height);
    
    streaming = true;
  }
}, false);  


// get sticker id
function icon(id){
    if(id != null){
      stickerName = id;
      photoButton.disabled = false;
      button.disabled = false;
    }
}

if(photoButton){
  photoButton.addEventListener('click', function(e) {
    takePicture();
    e.preventDefault()
  }, false);
}
}

if (button !=null){
  button.addEventListener('click', function(e){
    imageUpload();
    e.preventDefault();
  });
}

// add filter 
if (photoFilter != null){
  photoFilter.addEventListener('change', function(e){
    // video.style.filter = filter;
    e.preventDefault();
  });
}

// takePicture function 

function takePicture() {
  // e.preventDefault();
  // console.log(stickerName);
  if(stickerName) {
    // Create canvas
    const context = canvas.getContext('2d');
    if(width && height) {
      // set canvas props
    canvas.width = width;
    canvas.height = height
    // Draw an image of the video on the canvas
    // context.filter = filter;
    context.drawImage(video, 0, 0, width, height);
    // Create image from the canvas

    const imgUrl = canvas.toDataURL('image/png');
    // console.log('js', imgUrl);
    // Create image element
    const img = document.createElement('img');
      // console.log(imgUrl);
      // Set img src
      // img.setAttribute('src', imgUrl);
      // if(tokenImgId == null){
      //   tokenImgId = 0;
      // }
      // tokenImgId += 1;
      img.setAttribute('style', 'width:50%;height:100px;');
      // img.setAttribute('id', 'token-image'+tokenImgId);
      // img.addEventListener('click', function(){
      //   //deleting img
      //   var target = 
      // };
      // img.style.filter = filter;
      let firstChild = canvasDiv.firstChild;
      canvasDiv.insertBefore(img, firstChild);
      canvas.style.display = "none";
      
      // xhr php draw sticker into the token image;
      var params = "stickerName="+ stickerName + "&imgUrl="+imgUrl;
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'http://10.12.100.253/ok/Montages/draw', true);
      xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
      
      xhr.onload = function()
      {
        if(this.status == 200)
        {
        // console.log(this.responseText);
        let jsp = 'data:image/png;base64, '+ this.responseText;
        img.setAttribute('src', jsp);
        }
      };
      xhr.send(params);
  }
} else {alert('chose a sticker before take a photo');}
}

function imageUpload(){
  if(stickerName){
    var xhr = new XMLHttpRequest();
    var formdata = new FormData();

    xhr.open('POST', 'http://10.12.100.253/ok/Montages/upload');
    formdata.append('image', input.files[0]);
    formdata.append('sticker', stickerName);
    xhr.onload = function(){
    if(this.status == 200){
      parsed = JSON.parse(this.responseText)
      if(parsed['status'] == 'success'){
        if(video != null){
          video.remove();
        }
        // fc : first child
        // let fChild = vidDiv.firstChild[];
        // fChild.remove();
        // for (var x < vidDiv.no)
        if(vidDiv.children.length > 0){
          vidDiv.children[0].remove();
        }
        newImageDiv = document.createElement('div');
        newImageDiv.innerHTML = '<img id="uploaded" src="data:image/png;base64, '+ parsed["response"] + '">';
        vidDiv.appendChild(newImageDiv);
        const img = document.createElement('img');
        img.setAttribute('style', 'width:50%;height:100px;');
        canvasDiv = document.getElementById('canvasDiv');
        let firstChild = canvasDiv.children[0];
        canvasDiv.insertBefore(img, firstChild);
        canvas.style.display = "none";
        src = 'data:image/png;base64, '+ parsed['montage'];
        img.setAttribute('src', src);
      }
    }
    };
    xhr.send(formdata);
  } else {
    alert('chose a sticker before take a photo');
  }
  // echo sprintf('<img src="data:image/png;base64,%s" />', base64_encode($imageData));
}

function like($id){
  var PLN = document.getElementById('LN'+$id);
  var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://10.12.100.253/ok/posts/addLike?postId='+$id, true);
    xhr.onload = function(){
      if(this.status == 200){
        var ret = this.responseText.split('-');
        PLN.innerHTML = ret[1];
        var span = document.getElementsByClassName('like');
        for (var i = 0; i < span.length; i++)
        {
          if(span[i].id == $id){
            var target = span[i];
            if(ret[0] == 'Like'){
              target.innerHTML = 'favorite';
            }else if(ret[0] == 'Dislike'){
              target.innerHTML = 'favorite_border';
            }
            }
          }
        }
      
    };
    
xhr.onerror = function(){
  console.log("Error");
}
  xhr.send();
  // alert($id);
}


function comment($id){
  // alert($id);
  document.getElementById("pagination").style.display = "none";
  var grid = document.getElementById('gridId');
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://10.12.100.253/ok/posts/comment?postId='+$id, true);
  xhr.onload = function(){
    if(this.status == 200) {
      // console.log(this.responseText);
      // regex to get $json from php
      var str = this.responseText;
      // get from <div> to </div>
      var dv;
      if(dv = str.match(/<div>[\s\S]+<\/div>/)){
        var div = dv[0];
        // this above returns an array;
        // var output = div;
        var output = '';
        grid.innerHTML = div;
      }
      var found;
      if(found = str.match(/(\[.+\])/)){
        // var found = str.match(/(\[.+\])/)
        var comments = JSON.parse(found[0]);
        for(var i = 0; i < comments.length; i++){
          output += '\n' +
          '<div class="CComments">' +
            '<div class="iconAndName">' + 
              '<div><span class="material-icons">account_circle</span></div>' + 
              '<div><p class="by">'+comments[i].CommentOwnerName+': '+'</p></div>' + 
              '</div>' +
          '<p class="Ccomment">'+comments[i].comment+'</p>' +
          '</div>';
        }
      // console.log(output);
      var cH = document.getElementById('comments-holder');
      cH.innerHTML = output.trim();
    }
      // console.log(output);
      // cH.innerHTML = output;
      // section.innerHTML = output;
      // var tmp = document.createElement('div');
      // tmp.setAttribute('id', 'tmp');
      // tmp.innerHTML = output;
      // grid.appendChild(tmp);
      // cH.innerHTML = output;
      
      // console.log(cH);


      var ss = document.querySelector('.grid');
      ss.classList.replace('grid', 'Commentgrid');
    }
  xhr.onerror = function(){
    console.log("Error");
    }
  }
  xhr.send();
}

// addComment

function addComment($postId){
  var comment = document.getElementById('comment').value;

  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://10.12.100.253/ok/posts/addComment?comment='+comment+'&postId='+$postId, true);
  xhr.onload = function(){
    console.log(this.responseText);
    // co(this.responseText);
    document.getElementById('comment').value='';
    if(this.status == 200) {
      // console.log(this.responseText);
      var input = JSON.parse(this.responseText);
      // console.log(input);
      // handler.innerHTML = this.responseText;
      
      var cc = document.createElement("div"); // parent
      cc.setAttribute('class', "CComents");
      
      var grid = document.getElementById('gridId');
      grid.append(cc);

      
      var by = document.createElement("p");   // child
      by.setAttribute('class', "by");
      by.innerText = input.cpn+ ' :';
      cc.appendChild(by);

      
      var Com = document.createElement("p");  // child
      Com.setAttribute('class', "Ccomment");
      Com.innerText = input.comment;
      cc.appendChild(Com);
      // console.log('Com : ', Com);
      var holder = document.getElementById('comments-holder');
      holder.appendChild(cc);
    }
  xhr.onerror = function(){
    console.log("Error");
    }
  }
  xhr.send();
}

function EmailNotifOff(checked){
  alert(checked);
  xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://10.12.100.253/ok/Users/account?checked='+checked, true);
  xhr.onload = function(){
    if(this.status == 200){
      console.log(200);
      console.log(this.responseText);
    }
  }
  xhr.send();
}

function Delete(postId){
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'http://10.12.100.253/ok/posts/delete?postId='+postId, true);
  xhr.onload = function(){
    if(this.status == 200){
      // alert(this.responseText);
      var deletedImg = document.getElementById(this.responseText);
      if(deletedImg){
        var ParentImgDiv = deletedImg.parentElement;
      }
      ParentImgDiv.remove();
    }
  }
  xhr.send();
}

function slide(){
  const rl = document.querySelector('.rl');
  rl.classList.toggle('rl-active');
}
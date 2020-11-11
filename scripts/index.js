let addbtnCollection = document.querySelector('.add');
let addCollection = document.querySelector('.addCollection');
let deletebtnCollection = document.querySelector('.delete');
let deleteCollection = document.querySelector('.deleteCollection');

addbtnCollection.addEventListener('click', function() {
  addCollection.classList.toggle("addCollectionVision");
})

deletebtnCollection.addEventListener('click', function() {
  deleteCollection.classList.toggle("addCollectionVision");
})




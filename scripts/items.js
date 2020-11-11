let addbtnItem = document.querySelector('.add');
let addItem = document.querySelector('.addItem');

addbtnItem.addEventListener('click', function() {
  addItem.classList.toggle("addItemVision");
})

let ap = document.querySelector('.ap');
async function test () {
  const url = new URL(window.location.href);
  const param = url.searchParams.get("id");
  let response = await fetch("http://localhost/api/calculate.php?id=" + param)
  let data = await response.json();

  let apPrice = 0;
  let vpPrice = 0;
  let total = 0;
  for(let i = 0; i < data.length; i++) {
    let numbers = Number(data[i].ap);
    apPrice = apPrice + numbers;
  }

  for(let i = 0; i < data.length; i++) {
    let numbers = Number(data[i].vp);
    vpPrice = vpPrice + numbers;
  }

  total = apPrice - vpPrice;
  console.log(apPrice);
  ap.innerHTML = `Totaal: €${total}`

}
test();

let totalAmount = document.querySelector('.totalAmount');
console.log(totalAmount);
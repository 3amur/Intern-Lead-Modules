
var navbarTopShape = localStorage.getItem('phoenixNavbarTopShape');
          var navbarPosition = localStorage.getItem('phoenixNavbarPosition');
          var body = document.querySelector('body');
          var navbarDefault = document.querySelector('#navbarDefault');
          var navbarTopNew = document.querySelector('#navbarTopNew');
          var navbarSlim = document.querySelector('#navbarSlim');
          var navbarTopSlimNew = document.querySelector('#navbarTopSlimNew');
  
          var documentElement = document.documentElement;
          var navbarVertical = document.querySelector('.navbar-vertical');
  
          if (navbarTopShape === 'slim' && navbarPosition === 'vertical') {
            navbarDefault.remove();
            navbarTopNew.remove();
            navbarTopSlimNew.remove();
            navbarSlim.style.display = 'block';
            navbarVertical.style.display = 'inline-block';
            body.classList.add('nav-slim');
          } else if (navbarTopShape === 'slim' && navbarPosition === 'horizontal') {
            navbarDefault.remove();
            navbarVertical.remove();
            navbarTopNew.remove();
            navbarSlim.remove();
            navbarTopSlimNew.removeAttribute('style');
            body.classList.add('nav-slim');
          } else if (navbarTopShape === 'default' && navbarPosition === 'horizontal') {
            navbarDefault.remove();
            navbarSlim.remove();
            navbarVertical.remove();
            navbarTopSlimNew.remove();
            navbarTopNew.removeAttribute('style');
            documentElement.classList.add('navbar-horizontal')
  
          } else {
            body.classList.remove('nav-slim');
            navbarSlim.remove();
            navbarTopNew.remove();
            navbarTopSlimNew.remove();
            navbarDefault.removeAttribute('style');
            navbarVertical.removeAttribute('style');
          }
  
          var navbarTopStyle = localStorage.getItem('phoenixNavbarTopStyle');
          var navbarTop = document.querySelector('.navbar-top');
          if (navbarTopStyle === 'darker') {
            navbarTop.classList.add('navbar-darker');
          }
  
          var navbarVerticalStyle = localStorage.getItem('phoenixNavbarVerticalStyle');
          var navbarVertical = document.querySelector('.navbar-vertical');
          if (navbarVerticalStyle === 'darker') {
            navbarVertical.classList.add('navbar-darker');
          }


// toggle the arrow in vertical nav

let verticalNavFlag =  localStorage.getItem('phoenixIsNavbarVerticalCollapsed')
if (verticalNavFlag == 'true') {
    document.querySelector('#toggleArrow').classList.remove('d-none')
}
function toggleNavArrow(){
    let arrow = document.querySelector('#toggleArrow')
    let verticalNav = document.querySelector('.navbar-vertical-collapsed')
    if (!verticalNav) {
        arrow.classList.remove('d-none')
        arrow.classList.add('d-block')
    }else{
        arrow.classList.add('d-none')
    }
}



document.addEventListener('DOMContentLoaded', () => {
  const sortableLists = document.querySelectorAll('#sortable-list');

  sortableLists.forEach((list) => {
    Sortable.create(list, {
      swap: true, // Enable swap plugin
	    swapClass: 'highlight', // The class applied to the hovered swap item
	    animation: 150,
      chosenClass: 'chosen-element',
      ghostClass: "ghost",
      handle: '.pull-elements', // handle's class



      onEnd: (event) => {
        const itemId = event.item.id;
        const oldIndex = event.oldIndex;
        const newIndex = event.newIndex;
      },
    });
  });
});


document.addEventListener('DOMContentLoaded', function() {
  const forgetPasswordSwitch = document.getElementById('forgetPasswordSwitch');
  const resetPasswordSetting = document.querySelector('.reset-password-setting');
if (forgetPasswordSwitch) {
  forgetPasswordSwitch.addEventListener('change', function() {
      if (this.checked) {
          resetPasswordSetting.classList.remove('d-none');
      } else {
          resetPasswordSetting.classList.add('d-none');
      }
  });
}
});

{/* <script src="vendors/popper/popper.min.js"></script>
<script src="vendors/fontawesome/all.min.js"></script>
<script src="vendors/lodash/lodash.min.js"></script>
<script src="vendors/feather-icons/feather.min.js"></script>
<script src="assets/js/phoenix.js"></script>
<script src="vendors/sortablejs@1.10.2/Sortable.min.js"></script>
<script src="vendors/jquery-3.7.1.js"></script>
<script src="vendors/datatable/jquery.dataTables.min.js"></script>
<script src="vendors/bootstrap/bootstrap.min.js"></script>


<script src="vendors/datatable/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
<script  src="vendors/datatable/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.js"></script>

<!--  -->
<script src="vendors/datatable/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatable/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="vendors/datatable/select/1.7.0/js/dataTables.select.min.js"></script>
<script src="vendors/datatable/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="vendors/datatable/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="vendors/datatable/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="vendors/datatable/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="vendors/datatable/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="vendors/datatable//buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="vendors/datatable/buttons/2.4.2/js/buttons.html5.min.js"></script> */}
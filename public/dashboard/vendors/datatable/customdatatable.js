
$('.prevent-sort').off('click');
$('.prevent-sort').on('click', function(e) {
  e.stopPropagation();
});


// Initialize an empty array to store the text of th elements
var arrOfFilterBtn = [];

// Select all th elements inside the thead of the table and skip the first two
$('.useDataTable thead tr th').slice(2,-1).each(function(index) {   
  var id = 'checkbox_' + index;
    // Get the inner text of the th element and push it to thTextArray
    arrOfFilterBtn.push({ text :  ()=>{
      return `<div class="d-flex align-items-center"> <input class="me-2" id="${id}" type="checkbox">
       <label for=""${id}"">  ${$(this).text()}  <label>
       
       </div>`
    }, action: function (e, dt, node, config, cb) {
      var buttonElement = $(this.node());
      console.log('Button clicked:', buttonElement);
      $('#' + id).prop('checked', function(_, oldProp) {
        return !oldProp;
    });

      console.log('My custom button!');
  } });
});



// Add the button to console checked values
arrOfFilterBtn.push({
  text: function(){
    console.log(arrOfFilterBtn);
    return '<button class="btn btn-primary w-100 filterBtn" data-bs-toggle="modal" data-bs-target="#filterModal" >Filters</button>';
  },

  
  action: function(e, dt, node, config, cb) {
      var checkedValues = [];
      var columnIndex = [];
      // Iterate over each checkbox and log its ID and checked state
      $('.dt-bootstrap5 .row .col-md-auto.ms-auto .dt-buttons .btn-group:nth-child(2) .dropdown-menu .dt-button.dropdown-item span input[type="checkbox"]').each(function() {
          checkedValues.push({ id: $(this).attr('id'), checked: $(this).prop('checked') });
      });

      // Log the checked values array

      console.log('Checked Values:', checkedValues);

      // const filterButton = $('.filterBtn'); // Select the filter button

      // if (checkedValues.some(checkbox => checkbox.checked)) {
      //   console.log("aaaa");
      //   filterButton.removeClass('disabled'); // Remove the 'disabled' class
      // } else {
      //   console.log("bbbb");

      //   filterButton.addClass('disabled'); // Add the 'disabled' class
      // }

      
      const filterModal = document.querySelector('.filter-modal');
      filterModal.innerHTML = '';
      checkedValues.forEach((element,i) => {
        if (element.checked) {
        columnIndex.push(i + 2);
        const div = document.createElement('div');
        div.classList.add('filter-search');
        div.classList.add('col-10');


        const label = document.createElement('label');
        label.classList.add('form-check-label', 'pt-2','pb-1');
        label.setAttribute('for',columnTitleArr[i].toString().trim());
        label.textContent =columnTitleArr[i].toString().trim();

        const searchInput = document.createElement('input');
        searchInput.classList.add('form-control');
        searchInput.setAttribute('id',columnTitleArr[i].toString().trim());
        searchInput.setAttribute('type', 'text');
        searchInput.setAttribute('placeholder', columnTitleArr[i] + ' filter ');

        div.appendChild(label);
        div.appendChild(searchInput);
          
        filterModal.appendChild(div);
          
        console.log("the index of true element = "  + columnTitleArr[i].toString().trim());
        }else{

        }
      });

      $('.filter-modal input[type="text"]').on('input', function() {
        // Get the column index from the input's id
        const columnId = $(this).attr('id');
        let filterIndex ;
      console.log(columnId);
      columnTitleArr.map((item,index)=>{
        if(item.toString().trim() === columnId){
          console.log(item.toString().trim())
          console.log(index);
          filterIndex = index + 2

        }
      })
        // Get the search value from the input
        const searchValue = $(this).val();
        console.log(searchValue);
      
        // Apply the filter to the datatable
        table.columns(filterIndex).search(searchValue).draw();
      });
       
      
  }
});

  // Add an event listener to each search input

        
// $('[data-bs-toggle="popover"]').popover();
    // $('.useDataTable thead tr').first().before($('.useDataTable thead tr').clone(true).addClass('filters'));

var columnTitleArr = [];
var table = $('.useDataTable').DataTable({
 
  initComplete: function() {
    var api = this.api();

    // For each column starting from the third column
    for (var colIdx = 2; colIdx < api.columns().count() - 1; colIdx++) {
        (function(colIndex) { // Create a closure to capture the current colIdx value
            // Set the header cell to contain the input element
            // var cell = $('.filters th').eq(
            var cell = $('th').eq(
                $(api.column(colIndex).header()).index()
            );
            var title = $(cell).text();
            // $(cell).html('<input class="prevent-sort col-lg-12  form-control" type="text" placeholder="' + title + '" />');
            columnTitleArr.push(title);
            // // On every keypress in this input
            // $(
            //     'input',
            //     // $('.filters th').eq($(api.column(colIndex).header()).index())
            //     $('th').eq($(api.column(colIndex).header()).index())
            // )
            //     .off('keyup change')
            //     .on('change', function (e) {
            //         // Get the search value
            //         $(this).attr('title', $(this).val());
            //         var regexr = '({search})'; //$(this).parents('th').find('select').val();
            //         console.log(regexr);
            //         var cursorPosition = this.selectionStart;
            //         // Search the column for that value
            //         api
            //             .column(colIndex)
            //             .search(
            //                 this.value != ''
            //                     ? regexr.replace('{search}', '(((' + this.value + ')))')
            //                     : '',
            //                 this.value != '',
            //                 this.value == ''
            //             )
            //             .draw();
            //     })
            //     .on('keyup', function (e) {
            //         e.stopPropagation();

            //         $(this).trigger('change');
            //         $(this)
            //             .focus()[0]
            //             .setSelectionRange(cursorPosition, cursorPosition);
            //     });
        })(colIdx);
    }

},
  responsive: {
    orderable: false,
    details: {
        target: -1
    }
},


  layout: {
    top2Start: {
        buttons: [
          {
            text: 'Select All',
            // action: function () {
            //   table.rows().select();
            //   table.column(0).nodes().to$().find('input[type="checkbox"]').prop('checked', true);},
            action: function() {
              let allSelected = true;
              table.column(1).nodes().to$().find('input[type="checkbox"]').each(function() {
                if (!$(this).prop('checked')) {
                  allSelected = false;
                  return false; // break out of the each loop
                }
              });
          
              if (allSelected) {
                table.rows().deselect();
                table.column(0).nodes().to$().find('input[type="checkbox"]').prop('checked', false); 
              } else {
                table.rows().select();
                table.column(0).nodes().to$().find('input[type="checkbox"]').prop('checked', true);
              }
            },
            className: 'ms-1  rounded-1 mt-2'
          },
          {
            extend: 'copyHtml5',
            name:'copy',
            enabled: false,
            text: function() {
              // Return the HTML with the Bootstrap badge
              return '<span>Copy <span style="background :var(--phoenix-body-bg); color: var(--phoenix-1100) !important;  " class="badge badge-primary  ms-3 selected-badge">' + 0 + '</span></span>';
          },
              exportOptions: {
              columns: ':visible',
              rows:'active',
              modifier: {
                selected: true
              },
            },
            className: 'ms-1  rounded-1 mt-2 '
          },
          
              {
                extend: 'print',
                name:'print',
                enabled: false,
                text: function() {
                  // Return the HTML with the Bootstrap badge
                  return '<span>Print <span style="background :var(--phoenix-body-bg); color: var(--phoenix-1100) !important;"  class="badge badge-primary text-black ms-3 selected-badge">' + 0 + '</span></span>';
              },
                exportOptions: {
                  columns: ':nth-child(n+3):not(:last-child):visible',
                  modifier: {
                      selected: true
                  }
              },
              
                className: 'ms-1  rounded-1 mt-2'
                },

                {
                    text: 'Refresh',
                    action: function(e, dt, node, config) {
                      // Deselect all checkboxes
                      table.rows().deselect();
                      table.column(0).nodes().to$().find('input[type="checkbox"]').prop('checked', false);
                      window.location.reload();
          
                      // Reset the table to its initial state
                      // table.draw();
          
                  
                      // Reload the table data
                      // dt.ajax.reload();
                    },
                    className: 'ms-1  rounded-1 mt-2'

                  },
                {
                  extend: 'colvis',
                  // columns: 'th:nth-child(n+3):not(:last-child)',
                  // collectionLayout: 'columns',

                  popoverTitle: '<h5> Column visibility </h5>',
                  className: 'ms-1  rounded-1 mt-2'

              },
                
              ]
    },
    top2End:{
      buttons: [
       
      {
        extend: 'collection',
        text: 'Export',
        name:'export',
        popoverTitle: '<h5> Export </h5>',
        className: 'ms-1  rounded-1 mt-2',
        enabled:false,
        buttons: [
          {
            text: function(){
              return '<div data-bs-toggle="modal" data-bs-target="#exportModal"> Excel</div>'
            }
           
          },
          {
            text: function(){
              return '<div data-bs-toggle="modal" data-bs-target="#exportModal">PDF</div>'
            }
          },
          {
            text: function(){
              return '<div data-bs-toggle="modal" data-bs-target="#exportModal"> CSV</div>'
            }
          },
        ]
      },
      {
        extend: 'collection',
        text: ' Filter',
        popoverTitle: '<h5> Column Filter </h5>',
        className: 'ms-1  rounded-1 mt-2  d-block ',
        buttons: arrOfFilterBtn
      }
        ,
      //   {
      //   text: "Filter ",
      //   className: 'ms-1  rounded-1 mt-2 btn-filter1 d-none d-xl-block'
      // },
    ]
    },
},
  "language": {
      "lengthMenu": "Show _MENU_ ",
      "searchPlaceholder": "Users Search"
  },
  columnDefs: [{
      // className: 'dtr-control',
      orderable: false,
      render: DataTable.render.select(),
      targets: 1,
      className: 'select-checkbox',
  },
  {
    orderable: false,
    targets: 0,
  }],
  select: {
      style: 'multi',
      selector: 'input[type="checkbox"]',

      },

      stateSave: true,
      
    
  // order: [[2, '']]
});



$('#selectAllCurrentPage input').on('click', function() {
  let allSelected = true;
  table.rows({ page: 'current' }).nodes().to$().find('input[type="checkbox"]').each(function() {
      if (!$(this).prop('checked')) {
          allSelected = false;
          return false; // break out of the each loop
      }
  });

  if (allSelected) {
      table.rows({ selected: true }).deselect();
      table.rows({ page: 'current' }).nodes().to$().find('input[type="checkbox"]').prop('checked', false);
      $(this).prop('checked', false);
  } else {
      table.rows({ page: 'current' }).select();
      table.rows({ page: 'current' }).nodes().to$().find('input[type="checkbox"]').prop('checked', true);
      $(this).prop('checked', true);
    }
    // updateSelectedItemCount();
});

$('.useDataTable').on('page.dt draw.dt', function() {
  let allRowsSelected = true;
  table.rows({ page: 'current' }).nodes().to$().find('input[type="checkbox"]').each(function() {
      if (!$(this).prop('checked')) {
          allRowsSelected = false;
          return false; // break out of the each loop
      }
  });

  $('#selectAllCurrentPage input').prop('checked', allRowsSelected);
  // updateSelectedItemCount();
});

// $('.useDataTable tbody').on('click', 'tr', function() {
//   let checkbox = $(this).find('input[type="checkbox"]');
//   checkbox.prop('checked', !checkbox.prop('checked'));
//   // updateSelectedItemCount();
// });
function updateSelectedItemCount() {
  let selectInfoText = $('.dt-info .select-info .select-item:first-child').text();
  $('.selected-item').text(selectInfoText);
}

table.on('select deselect', function(e, dt, type, indexes) {
  var count = table.rows({ selected: true }).count();
  selectedCount = count
  $('.selected-item').text(count)
  $('.selected-badge').text(count)
  table.button('copy:name').enable(count > 0);
  table.button(2).enable(count > 0);
  table.button('export:name').enable(count > 0);

});



  table.on('responsive-resize', function(){
    $('.filters').hide();
    $('.text-head:nth-child(2)').show();
    table.columns.adjust().draw();
  })

  $('.btn-filter1').on('click', function() {
        
        $('.text-head:nth-child(2)').toggle();
        $('.filters').toggle();
        
        // Redraw the DataTable after toggling the headers
        table.columns.adjust().draw();
        // updateSelectedCounter();
        
      
        // Toggle the visibility of the '.text-head.filters' element
      });
      $('.filters').hide();
      $('.text-head:nth-child(2)').show();


   


const exportModal = document.querySelector('.export-modal');



columnTitleArr.forEach(element => {
console.log("aaaaaaaaa");
  
  const div = document.createElement('div');
  div.classList.add('form-check');
  div.classList.add('col-5');

  const input = document.createElement('input');
  input.classList.add('form-check-input');
  input.type = 'checkbox';
  input.id = element;
  input.value = element;

  const label = document.createElement('label');
  label.classList.add('form-check-label');
  label.setAttribute('for', element);
  label.textContent = element;

  div.appendChild(input);
  div.appendChild(label);

  exportModal.appendChild(div);
});

console.log(columnTitleArr);



$('.useDataTable thead tr th').slice(2, -1).each(function(index) {
  var id = 'checkbox_' + index;
  
  // Create checkbox button object and push it to the array
  arrOfFilterBtn.push({
      text: function() {
          return `<input id="${id}" type="checkbox"/>
                  <label for="${id}">${$(this).text()}</label>`;
      },
      action: function(e, dt, node, config, cb) {
          var buttonElement = $(this.node());
          console.log('Button clicked:', buttonElement);
          $('#' + id).prop('checked', function(_, oldProp) {
              return !oldProp;
          });
          console.log('My custom button!');
      }
  });

  // Create console button object and push it to the array
  
});



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
        console.log(!oldProp);
        if (oldProp) {
          table.columns(index + 2).search("").draw();
          searchValues = searchValues.filter(item=> item.Column_No !== index+2);
        }
        console.log(index +2);

        return !oldProp;
    });

      console.log('My custom button!');
  } });
});



var searchValues = []
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
        oldValueFlag = searchValues.find(item=>item.Column_No == i + 2 )
        if (oldValueFlag) {
          searchInput.value = oldValueFlag.Search_Criteria
        }
        // console.log(oldValueFlag);
        // if (searchValues) {

        // }

        div.appendChild(label);
        div.appendChild(searchInput);

        filterModal.appendChild(div);

        console.log("the index of true element = "  + columnTitleArr[i].toString().trim());
        }else{

        }
      });

      $('.filter-modal input[type="text"]').on('input', function() {
        // Get the column index from the input's id
        let columnId = $(this).attr('id');
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
        // Check if the filter already exists in searchValues
        const existingFilterIndex = searchValues.findIndex(item => item.Column_No === filterIndex);
        if (existingFilterIndex !== -1) {
            // If the filter exists, update its search criteria
            searchValues[existingFilterIndex].Search_Criteria = searchValue;
        } else {
            // If the filter doesn't exist, add it to searchValues
            searchValues.push({ Column_No: filterIndex, Search_Criteria: searchValue });
        }

        // console.log(columnTitleArr[filterIndex - 2])
        // $(`#${CSS.escape(columnTitleArr[filterIndex - 2])}`).val(searchValue);
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
    // paging: false,

    processing: true,
    serverSide: true,
      ajax: 'https://crm.astra-tech.net/api/dataTable',
      'columns': [
           {
              class: 'dt-control',
              orderable: false,
              data: null,
              defaultContent: ''
          },
           {
              class: 'select-checkbox',
              orderable: false,
              data: null,
              defaultContent: ''
          },
        //  { 'data' :  "created_by" },
         { 'data': 'id', class: 'text-start'},
         { 'data': 'name' , class: 'text-start'},
         { 'data': 'status' },
         { 'data': 'is_active' , class: 'text-start' },
         { 'data': 'created_at' , class: 'text-start'},
        //  { 'data': 'updated_at', class: 'text-start' },
         { 'data': 'action', class: 'text-start' }
      ],

      initComplete: function() {
        table.columns.adjust().draw();

        // Iterate over each column in the table
        this.api().columns().every(function(colIdx) {
          if (colIdx >= 2) {
              var column = this;
              // Get the title of each column and push it to columnTitleArr
              columnTitleArr.push($(column.header()).text());
          }
      });
      createExportModalElements();
    },

     responsive: {
       orderable: false,
       details: {
           target: 0
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
                  // console.log(table.rows({selected:true}).count());

                 if (allSelected) {
                   table.rows().deselect();
                   table.column(1).nodes().to$().find('input[type="checkbox"]').prop('checked', false);

                 } else {
                  //  table.rows().select();
                  table.rows({ search: 'applied' }).select();

                   table.column(1).nodes().to$().find('input[type="checkbox"]').prop('checked', true);
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
              columns: ':nth-child(n+3):not(:last-child):visible',
              modifier: {
                  selected: true
              }
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
                       text: '<i class="fa fa-refresh " aria-hidden="true"></i>',
                       action: function(e, dt, node, config) {
                         // Deselect all checkboxes
                         table.rows().deselect();
                         table.column(1).nodes().to$().find('input[type="checkbox"]').prop('checked', false);


                        //  data.search.search = '';
                        // $('.filter-search input').val('').trigger('input');
                        // state.columns.each.search = "";
                        // console.log(state);

                        // Reset the table to its initial state


                        // Reload the table data
                        dt.ajax.reload();
                        table.draw();
                        window.location.reload();
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
          stateSaveParams: function (settings, data) {
            console.log(data.columns);
            data.columns.map(item=>{
              item.search = "";
            });
          data.search.search = '';


    },

    "fnDrawCallback": function( oSettings ) {
      $('.selected-item').text(table.rows({ selected: true }).count());
      $('.selected-badge').text(table.rows({ selected: true }).count());
    },
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, 'All']
  ]


     // order: [[2, '']]
   });
   var state = table.state();

   console.log(state);

  function updateSelectedItemCount() {
    let selectInfoText = $('.dt-info .select-info .select-item:first-child').text();
    $('.selected-item').text(selectInfoText);
  }

// Event handler for select and deselect events on the DataTable
table.on('select deselect', function(e, dt, type, indexes) {
  var count = table.rows({ selected: true }).count();
  selectedCount = count;
  $('.selected-item').text(count);
  $('.selected-badge').text(count);
  table.button('copy:name').enable(count > 0);
  table.button(2).enable(count > 0);
  table.button('export:name').enable(count > 0);

  // Iterate over each selected row
  table.rows({ selected: true }).every(function(rowIdx) {
      // Get the corresponding checkbox and check it
      var checkbox = $(this.node()).find('td:eq(1) input[type="checkbox"]');
      checkbox.prop('checked', true);
  });
  table.rows({ selected: false }).every(function(rowIdx) {
      // Get the corresponding checkbox and check it
      var checkbox = $(this.node()).find('td:eq(1) input[type="checkbox"]');
      checkbox.prop('checked', false);
  });
});


    table.on('responsive-resize', function(){
      // $('.filters').hide();
      // $('.text-head:nth-child(2)').show();
      table.columns.adjust().draw();
    })

    // $('.btn-filter1').on('click', function() {

    //       $('.text-head:nth-child(2)').toggle();
    //       $('.filters').toggle();

    //       // Redraw the DataTable after toggling the headers
    //       table.columns.adjust().draw();
    //       // updateSelectedCounter();


    //       // Toggle the visibility of the '.text-head.filters' element
    //     });
    //     $('.filters').hide();
    //     $('.text-head:nth-child(2)').show();





        function createExportModalElements() {
          const exportModal = document.querySelector('.export-modal');

          columnTitleArr.forEach(element => {
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
      }

      function getCheckedCheckboxes() {
        const exportModal = document.querySelector('.export-modal');
        const checkboxes = exportModal.querySelectorAll('.form-check-input');
        const checkedCheckboxes = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedCheckboxes.push(checkbox.value);
            }
        });
        console.log(checkedCheckboxes);

        return checkedCheckboxes;
    }





    $('.useDataTable').on('page.dt', function () {
      console.log("aaaa");
      // var count = table.rows({ selected: true }).count();
      // selectedCount = count;
      $('.selected-item').text(table.rows({ selected: true }).count());
      $('.selected-badge').text(table.rows({ selected: true }).count());
    } );

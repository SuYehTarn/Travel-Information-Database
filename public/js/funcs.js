/*
* An Ajax method to get the path searching result with http
* Get request, and then render the current web page. It is
* applied on the path searching button.
*/
function getPath() {

    var from = sessionStorage.getItem('from');
    var to   = sessionStorage.getItem('to');

    if (! from || ! to ) { return; }

    $.get(`/path/from=${from}+to=${to}`, function(data) {
        paths = JSON.parse(data);
        sessionStorage.setItem('paths', paths);
    });

    /*$.get(`/path/from=${from}+to=${to}`, function(html) {
        
        // Display the from-attraction.
        $("#path-from-attra").empty().text(from);
        
        // Display the to-attraction.
        $("#path-to-attra").empty().text(to);        

        // Display the path steps list returned for the server.
        $('#path-steps-list').empty().append(html);

        // Count the path result amount.
        var pnum = $('.path-steps').length;

        if (pnum) {

            // Store the page index.
            sessionStorage.setItem('path_index', 1);

            // Display the page index.
            $('#path-page').empty().text(`${1}/${pnum}`);            

            // Display the first page.
            $(`.path-steps:eq(0)`).css('display', '');
        }

        // Display the path modal.
        $('#pathModal').modal('toggle');
    });*/
}

/*
* An ajax method to get the address and opening time information
* from the server, and then render the current web page. It is 
* applied on each attration panel.
*
* @arg elem: DOM.
*/
function getAttraInfo(elem) {
    //var modal = $(elem.dataset.target).find(`.modal-body`);
    var attra = elem.dataset.value;

    $.get(`/attractions/info=${attra}`, function(html) {
        $('#attraInfo .modal-title').empty().text(attra);
        $('#attraInfo .modal-body').empty().append(html);
        $('#attraInfo').modal('toggle');
        //modal.empty().append(html);
    });
}

/*
* A method combines two DOM building method that the built DOMs
* are relative to the user-added list. It would refresh the
* current web page according to the renewed user-added list.
*/
function refresh() {
    buildAddList();
    buildAddAttraIcon();
}

/*
* A DOM building method build the user added attraction panels
* accroding to the user-added list stored in local memory.
*/
function buildAddList() {

    var list = JSON.parse(sessionStorage.getItem('add_list'));
    
    if (!list) {
        $('#add_list').append(
            $(document.createElement('p'))
                .addClass('text-center')
                .text('請選取景點'));
        return;
    }

    $('#add_list').empty();

    for (let attra of list) {

        var icon = $(document.createElement('i'))
            .addClass('fas fa-minus add-attra-icon')
            .click( function() {
                addAttra(event, $(this));
            });

        var item = $(document.createElement('div'))
            .addClass('list-group-item add-item')
            .addClass('justify-content-between d-flex')
            .addClass('align-items-center')
            .data('value', attra)
            .text(attra)
            .append(icon)
            .click( function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $('#add_list .list-group-item')
                        .removeClass('active');
                    $(this).addClass('active');
                }
            });

        $('#add_list').append(item);
    }
    setFromToTag();
}

/*
* A DOM building method attaching the adding icon for each
* attraction panel accroding to whether the attraction is
* in the user-added list or not.
*/
function buildAddAttraIcon() {    
    $('#attra .add-attra-icon')
        .removeClass('fa-check')
        .addClass('fa-plus');
    
    var list = JSON.parse(sessionStorage.getItem('add_list'));
    
    if (!list) { return; }

    $('#attra .list-group-item')
        .filter( function() {
            return list.includes($(this).data('value'));
        })
        .find('.add-attra-icon')
        .removeClass('fa-plus')
        .addClass('fa-check');
}

/*
* A method moving an attraction in or out the locally
* stored user-added list.
*/
function addAttra(event, elem) {
    /*
    * Get the user-added list from the local storage.
    * If it is not exists, set as an empty array.
    */
    var list = JSON.parse(sessionStorage.getItem('add_list'));
    if ( !Array.isArray(list) ) { list = []; }

    /*
    * An attraction is added into the iser-added list
    * if it is not in the list, otherwise, it would be
    * removed from the list. 
    */
    var attraName = $(elem).parent().data('value');
    if ( !list.includes(attraName) ) {
        list.push(attraName);
    
    } else {
        list = list.filter(attra => attra != attraName);
    }
    /*
    * Store the user-added list and refresh the web
    * page accroding to it.
    */
    sessionStorage.setItem('add_list', JSON.stringify(list));
    refresh();

    // Stop the click event to avoid clicking the attraction panel.
    event.stopPropagation();
}

/*
* A method clearinf the user-added list after a confirmation.
*/
function clearAddList() {
    if (confirm("確定清空收藏景點列表")) {
        sessionStorage.removeItem('add_list', JSON.stringify([]));
        sessionStorage.removeItem('to');
        sessionStorage.removeItem('from');
        refresh();
    }
}

/*
* A method moving the specific attraction in the user-added
* list for one place forward or backward.
*/
function moveAttra(dir) {

    // Return if no selected attraction.
    if ( ! $(".add-item.active").length ) { return; }

    // Return if the direction is wrong.
    if (dir != 'fore' && dir != 'back') { return; }

    var list = JSON.parse(sessionStorage.getItem('add_list'));
    var value = $(".add-item.active").text();
    var index = list.indexOf(value);

    // Return if the index is out of defined range.
    if ( index-1 < 0 || index+1 > list.length-1 ) { return; }

    if (dir == 'fore') { var tIndex = index-1; }
    if (dir == 'back') { var tIndex = index+1; }

    var tmp = list[tIndex];
    list[tIndex] = list[index];
    list[index] = tmp;

    sessionStorage.setItem('add_list', JSON.stringify(list));
    refresh();
    $(`.add-item:contains('${value}')`).addClass('active');
}

/*
* A method setting the from-attraction and the to-attraction,
* storing locally, and then stick the tag.
*/
function setFromToTag(tag) {

    /*
    * Set the from and to attraction
    */
    if (tag && $("#add_list .active").length) {

        var attra = $("#add_list .active").text();    
        
        var anti_tag = (tag == 'from') ? 'to' : 'from';

        if (sessionStorage.getItem(anti_tag) == attra) {
            sessionStorage.removeItem(anti_tag);
        }

        if (sessionStorage.getItem(tag) == attra) {
            sessionStorage.removeItem(tag);

        } else {
            sessionStorage.setItem(tag, attra);
        }
    }

    var list = JSON.parse(sessionStorage.getItem('add_list'));

    $('.add-item').removeClass('bg-primary bg-info');

    /*
    * Stick the from-tag
    */
    var from = sessionStorage.getItem('from');
    
    if (from) {
        
        if (!list.includes(from)) {
            sessionStorage.removeItem('from');
        }

        $(`.add-item:contains('${from}')`)
            .addClass('from bg-primary');
    }

    /*
    * Stick the to-tag
    */
    var to = sessionStorage.getItem('to');

    if (to) {

        if (!list.includes(to)) {
            sessionStorage.removeItem('to');
        }

        $(`.add-item:contains('${to}')`)
            .addClass('to bg-info');
    }
}


/*
* A method of displaying the previous or the next page
* of a path result page.
*/
function changePage(dir) {
    
    var index = parseInt(sessionStorage.getItem('path_index'));
    if (!index) { return; }

    if (dir == 'prev') { var tIndex = index-1; }
    if (dir == 'next') { var tIndex = index+1; }

    var pageExists = Boolean( $(`#path-steps-${tIndex}`).length );

    if ( pageExists ) {

        // Hide all pages.
        $('.path-steps').css('display', 'none');

        // Display the target page.
        $(`#path-steps-${tIndex}`).fadeIn();

        // Renew the page number.
        var text = $('#path-page').text().split('/');
        text[0] = tIndex;
        $('#path-page').text(text.join('/'));
        
        // Save the new page index.
        sessionStorage.setItem('path_index', tIndex);  
    }
}
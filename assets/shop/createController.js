!function ($) {
    "use strict";

    var AdvancedForm = function () {
    };

    AdvancedForm.prototype.init = function () {

        $("form").bind("keypress", function (e) {
            if (e.keyCode == 13) {
                return false;
            }
        });


        //for category---------------------------------------------------
        var $collectionHolder2;

        // setup an "add a tag" link
        var $addTagButton2 = $('<button type="button" class="add_children_link btn btn-sm btn-primary">Add Category</button>');
        var $newLinkLi2 = $('<li><hr/></li>').append($addTagButton2);

        // Get the ul that holds the collection of tags
        $collectionHolder2 = $('ul.category');

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder2.data('index', $collectionHolder2.find(':input').length);

        $addTagButton2.on('click', function (e) {
            // add a new tag form (see next code block)
            addTagForm($collectionHolder2, $newLinkLi2);
        });

        // add a delete link to all of the existing tag form li elements
        $collectionHolder2.find('li').each(function () {
            addTagFormDeleteLink2($(this));
        });

        // add the "add a tag" anchor and li to the tags ul
        $collectionHolder2.append($newLinkLi2);

        function addTagForm($collectionHolder2, $newLinkLi2) {
            // Get the data-prototype explained earlier
            var prototype = $collectionHolder2.data('prototype');

            // get the new index
            var index = $collectionHolder2.data('index');

            var newForm = prototype;
            // You need this only if you didn't set 'label' => false in your tags field in TaskType
            // Replace '__name__label__' in the prototype's HTML to
            // instead be a number based on how many items we have
            // newForm = newForm.replace(/__name__label__/g, index);

            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            newForm = newForm.replace(/__name__/g, index);

            $('#menu_categories_'+index).addClass("form-group row");
            // console.log("menu_categories_"+index);
            // increase the index with one for the next item
            $collectionHolder2.data('index', index + 1);

            // console.log(index);
            // console.log(newForm);

            // Display the form in the page in an li, before the "Add a tag" link li
            var $newFormLi2 = $('<li><hr/></li>').append(newForm);
            $newLinkLi2.before($newFormLi2);

            // add a delete link to the new form
            addTagFormDeleteLink2($newFormLi2);
        }

        function addTagFormDeleteLink2($tagFormLi2) {
            var $removeFormButton2 = $('<button type="button" class="btn btn-sm btn-danger">Delete Category</button>');
            $tagFormLi2.append($removeFormButton2);

            $removeFormButton2.on('click', function (e) {
                // remove the li for the tag form
                $tagFormLi2.remove();
            });
        }
        //for category end------------------------------------------




        //for slider---------------------------------------------------
        var $collectionHolder3;

        // setup an "add a tag" link
        var $addTagButton3 = $('<button type="button" class="add_children_link btn btn-sm btn-primary">Add</button>');
        var $newLinkLi3 = $('<li><hr/></li>').append($addTagButton3);

        // Get the ul that holds the collection of tags
        $collectionHolder3 = $('ul.slider');

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder3.data('index', $collectionHolder3.find(':input').length);

        $addTagButton3.on('click', function (e) {
            // add a new tag form (see next code block)
            addTagForm($collectionHolder3, $newLinkLi3);
        });

        // add a delete link to all of the existing tag form li elements
        $collectionHolder3.find('li').each(function () {
            addTagFormDeleteLink3($(this));
        });

        // add the "add a tag" anchor and li to the tags ul
        $collectionHolder3.append($newLinkLi3);

        function addTagForm($collectionHolder3, $newLinkLi3) {
            // Get the data-prototype explained earlier
            var prototype = $collectionHolder3.data('prototype');

            // get the new inde
            var index = $collectionHolder3.data('index');

            var newForm = prototype;
            // You need this only if you didn't set 'label' => false in your tags field in TaskType
            // Replace '__name__label__' in the prototype's HTML to
            // instead be a number based on how many items we have
            // newForm = newForm.replace(/__name__label__/g, index);

            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            newForm = newForm.replace(/__name__/g, index);

            $('#menu_categories_'+index).addClass("form-group row");
            // console.log("menu_categories_"+index);
            // increase the index with one for the next item
            $collectionHolder3.data('index', index + 3);

            // console.log(index);
            // console.log(newForm);

            // Display the form in the page in an li, before the "Add a tag" link li
            var $newFormLi3 = $('<li><hr/></li>').append(newForm);
            $newLinkLi3.before($newFormLi3);

            // add a delete link to the new form
            addTagFormDeleteLink3($newFormLi3);
        }

        function addTagFormDeleteLink3($tagFormLi3) {
            var $removeFormButton3 = $('<button type="button" class="btn btn-sm btn-danger">Delete</button>');
            $tagFormLi3.append($removeFormButton3);

            $removeFormButton3.on('click', function (e) {
                // remove the li for the tag form
                $tagFormLi3.remove();
            });
        }
//for slider end------------------------------------------


    },
        //init
        $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),

//initializing
    function ($) {
        "use strict";
        $.AdvancedForm.init();
    }(window.jQuery);
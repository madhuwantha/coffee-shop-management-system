


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


        //for Video---------------------------------------------------
        var $collectionHolder1;

        // setup an "add a tag" link
        var $addTagButton1 = $('<button type="button" class="add_children_link btn btn-sm btn-primary">Add Video</button>');
        var $newLinkLi1 = $('<li><hr/></li>').append($addTagButton1);

        // Get the ul that holds the collection of tags
        $collectionHolder1 = $('ul.galleryVideo');

        // count the current form inputs we have (e.g. 1), use that as the new
        // index when inserting a new item (e.g. 1)
        $collectionHolder1.data('index', $collectionHolder1.find(':input').length);

        $addTagButton1.on('click', function (e) {
            // add a new tag form (see next code block)
            addTagForm($collectionHolder1, $newLinkLi1);
        });

        // add a delete link to all of the existing tag form li elements
        $collectionHolder1.find('li').each(function () {
            addTagFormDeleteLink1($(this));
        });

        // add the "add a tag" anchor and li to the tags ul
        $collectionHolder1.append($newLinkLi1);

        function addTagForm($collectionHolder1, $newLinkLi1) {
            // Get the data-prototype explained earlier
            var prototype = $collectionHolder1.data('prototype');

            // get the new index
            var index = $collectionHolder1.data('index');

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
            $collectionHolder1.data('index', index + 1);

            // console.log(index);
            // console.log(newForm);

            // Display the form in the page in an li, before the "Add a tag" link li
            var $newFormLi1 = $('<li><hr/></li>').append(newForm);
            $newLinkLi1.before($newFormLi1);

            // add a delete link to the new form
            addTagFormDeleteLink1($newFormLi1);
        }

        function addTagFormDeleteLink1($tagFormLi1) {
            var $removeFormButton1 = $('<button type="button" class="btn btn-sm btn-danger">Delete Video</button>');
            $tagFormLi1.append($removeFormButton1);

            $removeFormButton1.on('click', function (e) {
                // remove the li for the tag form
                $tagFormLi1.remove();
            });
        }
        //for Video end------------------------------------------







        //for images---------------------------------------------------
        var $collectionHolder2;

        // setup an "add a tag" link
        var $addTagButton2 = $('<button type="button" class="add_children_link btn btn-sm btn-primary">Add Image</button>');
        var $newLinkLi2 = $('<li><hr/></li>').append($addTagButton2);

        // Get the ul that holds the collection of tags
        $collectionHolder2 = $('ul.galleryImag');

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
            var $removeFormButton2 = $('<button type="button" class="btn btn-sm btn-danger">Delete Image</button>');
            $tagFormLi2.append($removeFormButton2);

            $removeFormButton2.on('click', function (e) {
                // remove the li for the tag form
                $tagFormLi2.remove();
            });
        }
        //for images end------------------------------------------

    },
        //init
        $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),

//initializing
    function ($) {
        "use strict";
        $.AdvancedForm.init();
    }(window.jQuery);
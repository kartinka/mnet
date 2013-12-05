<?php
/* @var $this UserController */
/* @var $model User */

?>

<script>
    $(function() {
        $('.typeahead').typeahead({
            source: function (query, process) {
                var url='/mednet/protected/views/solr/SolrPhpClient/institutions.php';
                return $.get(url, { term: query }, function (data) {
                    return process(data.options);
                });
            },
            /*
             matcher: function (item) {
             var match=false;
             n=item.split(" ");
             for (var i = 0; i < n.length; i++) {
             if (n.toLowerCase().indexOf(this.query.trim().toLowerCase()) != -1) {
             return true;
             }
             }
             },
             */
            matcher : function (item) { return(true)},
            /*
             highlighter: function (item) {
             //need to ignore <strong>
             n=this.query.match(/[^ ]+/g);
             for (var i = 0; i < n.length; i++) {
             var regex = new RegExp( '(' + n[i] + ')', 'gi' );
             item= item.replace( regex, "<strong>$1</strong>" );
             }
             return (item);
             },
             */
            //matchContains : true,
            minLength : 3,
        });
    });

</script>


<div class="row">
    <div class="span8 offset2">
        <h1>Registration</h1>
        <?php $this->renderPartial('registration_form', array('model'=>$model)); ?>
    </div>
</div>
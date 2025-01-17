


CKEDITOR.dialog.add( 'abbrDialog', function( editor ) {
    return {
        title: 'Abbreviation Properties',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'select',
                        id: 'abbr',
                        label: 'Select ',
                        items: [ [ 'Company' ], [ 'Object' ], [ 'Template' ]  ],
                            'default': 'Company',
                        onChange: function( api ) {

                            $.post("/welcome/ckeditorajax/"+ this.getValue(), function(response)
                            {
                                console.log(response);
                                //$('abbr').append();
                                
                                
                                //$("#cke_126_select").append(new Option(myObj.variable, myObj.var_content));
                                
                                
                                    for (i = 0; i < response.length; i++) {
                                       $(".cvbcvbcvbcv").append(new Option(response[i].variable, response[i].var_content));
                                    }    
                                


                                //array = response;
                            },'json');

                        }
                    },
                    {
                        type: 'select',
                        id: 'abbr',
                        className: 'cvbcvbcvbcv',
                        label: 'Select ',
                        items: [   ],
                            'default': 'Company',
                        /*onChange: function( api ) {

                            $.post("/welcome/ckeditorajax/"+ this.getValue(), function(response)
                            {
                                console.log(response);
                            },'json');

                        }*/
                    }
                ]
            }/*,
            {
                id: 'tab-adv',
                label: 'Advanced Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'id',
                        label: 'Id'
                    }
                ]
            }*/
        ],
        onOk: function() {
            
			var dialog = this;
			var abbr = "asdasd";
			editor.insertElement( abbr );
			//editor.insertHtml( 'The current date and time is: <em>' + avbbr+ '</em>' );
    };
});

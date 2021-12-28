/*
* File:        jquery.dataTables.editable.js
* Version:     1.3.
* Author:      Jovan Popovic 
* 
* Copyright 2010-2011 Jovan Popovic, all rights reserved.
*
* This source file is free software, under either the GPL v2 license or a
* BSD style license, as supplied with this software.
* 
* This source file is distributed in the hope that it will be useful, but 
* WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
* or FITNESS FOR A PARTICULAR PURPOSE. 
* 
* Parameters:
* @sUpdateURL                   	String      URL of the server-side page used for updating cell. Default value is "UpdateData".
* @sAddURL                      	String      URL of the server-side page used for adding new row. Default value is "AddData".
* @sDeleteURL                   	String      URL of the server-side page used to delete row by id. Default value is "DeleteData".
* @fnShowError                  	Function    function(message, action){...}  used to show error message. Action value can be "update", "add" or "delete".
* @sAddNewRowFormId             	String      Id of the form for adding new row. Default id is "formAddNewRow".
* @oAddNewRowFormOptions            Object	    Options that will be set to the "Add new row" dialog
* @sAddNewRowButtonId           	String      Id of the button for adding new row. Default id is "btnAddNewRow".
* @oAddNewRowButtonOptions		    Object	    Options that will be set to the "Add new" button
* @sAddNewRowOkButtonId         	String      Id of the OK button placed in add new row dialog. Default value is "btnAddNewRowOk".
* @oAddNewRowOkButtonOptions		Object	    Options that will be set to the Ok button in the "Add new row" form
* @sAddNewRowCancelButtonId     	String      Id of the Cancel button placed in add new row dialog. Default value is "btnAddNewRowCancel".
* @oAddNewRowCancelButtonOptions	Object	    Options that will be set to the Cancel button in the "Add new row" form
* @sDeleteRowButtonId           	String      Id of the button for adding new row. Default id is "btnDeleteRow".
* @oDeleteRowButtonOptions		    Object	    Options that will be set to the Delete button
* @sSelectedRowClass            	String      Class that will be associated to the selected row. Default class is "row_selected".
* @sReadOnlyCellClass           	String      Class of the cells that should not be editable. Default value is "read_only".
* @sAddDeleteToolbarSelector    	String      Selector used to identify place where add and delete buttons should be placed. Default value is ".add_delete_toolbar".
* @fnStartProcessingMode        	Function    function(){...} called when AJAX call is started. Use this function to add "Please wait..." message  when some button is pressed.
* @fnEndProcessingMode          	Function    function(){...} called when AJAX call is ended. Use this function to close "Please wait..." message.
* @aoColumns                    	Array       Array of the JEditable settings that will be applied on the columns
* @sAddHttpMethod               	String      Method used for the Add AJAX request (default is 'POST')
* @sDeleteHttpMethod            	String      Method used for the Delete AJAX request (default is 'POST')
* @fnOnDeleting                 	Function    function(tr, id, fnDeleteRow){...} Function called before row is deleted.
                                                    tr isJQuery object encapsulating row that will be deleted
                                                    id is an id of the record that will be deleted.
                                                    fnDeleteRow(id) callback function that should be called to delete row with id
                                                    returns true if plugin should continue with deleting row, false will abort delete.
* @fnOnDeleted                  	Function    function(status){...} Function called after delete action. Status can be "success" or "failure"
* @fnOnAdding                   	Function    function(){...} Function called before row is added.
                                                    returns true if plugin should continue with adding row, false will abort add.
* @fnOnNewRowPosted			        Function    function(data) Function that can override default function that is called when server-side sAddURL returns result
                                                    You can use this function to add different behaviour when server-side page returns result
* @fnOnAdded                    	Function    function(status){...} Function called after delete action. Status can be "success" or "failure"
* @fnOnEditing                  	Function    function(input){...} Function called before cell is updated.
                                                    input JQuery object wrapping the inut element used for editing value in the cell.
                                                    returns true if plugin should continue with sending AJAX request, false will abort update.
* @fnOnEdited                   	Function    function(status){...} Function called after edit action. Status can be "success" or "failure"
* @sEditorHeight                	String      Default height of the cell editors
* @sEditorWidth                 	String      Default width of the cell editors
* @oDeleteParameters                Object      Additonal objects added to the DELETE Ajax request
* @sIDToken                         String      Token in the add new row dialog that will be replaced with a returned id of the record that is created
*/
(function ($) {

    $.fn.makeEditable = function (options) {

        var iDisplayStart = 0;

        ///Utility function used to determine id of the cell
        //By default it is assumed that id is placed as an id attribute of <tr> that that surround the cell (<td> tag). E.g.:
        //<tr id="17">
        //  <td>...</td><td>...</td><td>...</td><td>...</td>
        //</tr>
        function fnGetCellID(cell) {
            return properties.fnGetRowID($(cell.parentNode));
        }

        ///Utility function used to set id of the new row
        //It is assumed that id is placed as an id attribute of <tr> that that surround the cell (<td> tag). E.g.:
        //<tr id="17">
        //  <td>...</td><td>...</td><td>...</td><td>...</td>
        //</tr>
        function _fnSetRowIDInAttribute(row, id) {
            row.attr("id", id);
        }

        //Utility function used to get id of the row
        //It is assumed that id is placed as an id attribute of <tr> that that surround the cell (<td> tag). E.g.:
        //<tr id="17">
        //  <td>...</td><td>...</td><td>...</td><td>...</td>
        //</tr>
        function _fnGetRowIDFromAttribute(row) {
            return row.attr("id");
        }

        //Utility function used to set id of the new row
        //It is assumed that id is placed as an id attribute of <tr> that that surround the cell (<td> tag). E.g.:
        //<tr>
        //  <td>17</td><td>...</td><td>...</td><td>...</td>
        //</tr>
        function _fnSetRowIDInFirstCell(row, id) {
            $("td:first", row).html(id);
        }

        //Utility function used to get id of the row
        //It is assumed that id is placed as an id attribute of <tr> that that surround the cell (<td> tag). E.g.:
        //<tr>
        //  <td>17</td><td>...</td><td>...</td><td>...</td>
        //</tr>
        function _fnGetRowIDFromFirstCell(row) {
            return $("td:first", row).html();
        }

        //Reference to the DataTable object
        var oTable;
        //Refences to the buttons used for manipulating table data
		//declare object onedha 
        var oAddNewRowButton, oDeleteRowButton, oBacaKeluarRowButton, oUpdateRefRowButton, oBacaRowButton, oBacaNotaDinasRowButton, 
		oDisposisiRowButton, oDisposisiNotaDinasRowButton, oTandaTerimaDisposisiRowButton, oEditEntryMasukRowButton, 
		oEditEntryKeluarRowButton, oEditNotaDinasRowButton, oSuratKeluarRowButton, oConfirmRowAddingButton, oCancelRowAddingButton, oBulanRowSelect, oTahunRowSelect;
		
        //Reference to the form used for adding new data
        var oAddNewRowForm;

        //Plugin options
        var properties;

        /// Utility function that shows an error message
        ///@param errorText - text that should be shown
        ///@param action - action that was executed when error occured e.g. "update", "delete", or "add"
        function fnShowError(errorText, action) {
            alert(errorText);
        }

        //Utility function that put the table into the "Processing" state
        function fnStartProcessingMode() {
            if (oTable.fnSettings().oFeatures.bProcessing) {
                $(".dataTables_processing").css('visibility', 'visible');
            }
        }

        //Utility function that put the table in the normal state
        function fnEndProcessingMode() {
            if (oTable.fnSettings().oFeatures.bProcessing) {
                $(".dataTables_processing").css('visibility', 'hidden');
            }
        }

        var sOldValue, sNewCellValue, sNewCellDislayValue;
        //Utility function used to apply editable plugin on table cells
        function _fnApplyEditable(aoNodes) {
            return;
        }
		
		/*
		function _fnApplyEditable(aoNodes) {
            if (properties.bDisableEditing)
                return;
            var oDefaultEditableSettings = {
                event: 'dblclick',
                "callback": function (sValue, settings) {
                    properties.fnEndProcessingMode();
                    var status = "";
                    if (sNewCellValue == sValue) {
                        var aPos = oTable.fnGetPosition(this);
                        oTable.fnUpdate(sNewCellDisplayValue, aPos[0], aPos[2]);
                        status = "success";
                    } else {
                        var aPos = oTable.fnGetPosition(this);
                        oTable.fnUpdate(sOldValue, aPos[0], aPos[2]);
                        properties.fnShowError(sValue, "update");
                        status = "failure";
                    }

                    properties.fnOnEdited(status, sOldValue, sNewCellDisplayValue, aPos[0], aPos[1], aPos[2]);
                    if (settings.fnOnCellUpdated != null) {
                        settings.fnOnCellUpdated(status, sValue, settings);
                    }
                    _fnSetDisplayStart();

                },
                "onsubmit": function (settings, original) {
                    var input = $("input,select,textarea", this);
                    sOldValue = original.revert;
                    sNewCellValue = $("input,select,textarea", $(this)).val();
                    if (input.length == 1) {
                        var oEditElement = input[0];
                        if (oEditElement.nodeName.toLowerCase() == "select" || oEditElement.tagName.toLowerCase() == "select")
                            sNewCellDisplayValue = $("option:selected", oEditElement).text(); //For select list use selected text instead of value for displaying in table
                        else
                            sNewCellDisplayValue = sNewCellValue;
                    }

                    if (!properties.fnOnEditing(input))
                        return false;
                    var x = settings;
                    if (settings.cssclass != null) {
                        input.addClass(settings.cssclass);
                        if (!input.valid() || 0 == input.valid())
                            return false;
                        else
                            return true;
                    }
                },
                "submitdata": function (value, settings) {
                    iDisplayStart = _fnGetDisplayStart();
                    properties.fnStartProcessingMode();
                    var id = fnGetCellID(this);
                    var rowId = oTable.fnGetPosition(this)[0];
                    var columnPosition = oTable.fnGetPosition(this)[1];
                    var columnId = oTable.fnGetPosition(this)[2];
                    var sColumnName = oTable.fnSettings().aoColumns[columnId].sName;
                    if (sColumnName == null || sColumnName == "")
                        sColumnName = oTable.fnSettings().aoColumns[columnId].sTitle;
                    return {
                        "id": id,
                        "rowId": rowId,
                        "columnPosition": columnPosition,
                        "columnId": columnId,
                        "columnName": sColumnName
                    };
                },
                "onerror": function () {
                    properties.fnEndProcessingMode();
                    properties.fnShowError("Cell cannot be updated(Server error)", "update");
                    properties.fnOnEdited("failure");
                },
                "height": properties.sEditorHeight,
                "width": properties.sEditorWidth
            };

            var cells = null;
            if (properties.aoColumns != null) {
                for (var i = 0; i < properties.aoColumns.length; i++) {
                    if (properties.aoColumns[i] != null) {
                        cells = $("td:nth-child(" + (i + 1) + ")", aoNodes);
                        var oColumnSettings = oDefaultEditableSettings;
                        oColumnSettings = $.extend({}, oDefaultEditableSettings, properties.aoColumns[i]);
                        var sUpdateURL = properties.sUpdateURL;
                        try {
                            if (oColumnSettings.sUpdateURL != null)
                                sUpdateURL = oColumnSettings.sUpdateURL;
                        } catch (ex) {
                        }
                        cells.editable(sUpdateURL, oColumnSettings);
                    }


                }
            } else {
                cells = $('td:not(.' + properties.sReadOnlyCellClass + ')', aoNodes);
                cells.editable(properties.sUpdateURL, oDefaultEditableSettings);

            }

        }
		*/
		
        //Called when user confirm that he want to add new record
        function _fnOnRowAdding(event) {
            if (properties.fnOnAdding()) {
                if (oAddNewRowForm.valid()) {
                    iDisplayStart = _fnGetDisplayStart();
                    properties.fnStartProcessingMode();
                    var params = oAddNewRowForm.serialize();
                    $.ajax({ 'url': properties.sAddURL,
                        'data': params,
                        'type': properties.sAddHttpMethod,
                        "dataType": "text",
                        success: _fnOnRowAdded,
                        error: function (response) {
                            properties.fnEndProcessingMode();
                            properties.fnShowError(response.responseText, "add");
                            properties.fnOnAdded("failure");
                        }
                    });
                }
            }
            event.stopPropagation();
            event.preventDefault();
        }

        function _fnOnNewRowPosted(data) {

            return true;

        }
        ///Event handler called when a new row is added and response is returned from server
        function _fnOnRowAdded(data) {
            properties.fnEndProcessingMode();

            if (properties.fnOnNewRowPosted(data)) {

                var oSettings = oTable.fnSettings();
                var iColumnCount = oSettings.aoColumns.length;
                var values = new Array();

                $("input:text[rel],input:radio[rel][checked],input:hidden[rel],select[rel],textarea[rel],span.datafield[rel]", oAddNewRowForm).each(function () {
                    var rel = $(this).attr("rel");
                    var sCellValue = "";
                    if (rel >= iColumnCount)
                        properties.fnShowError("In the add form is placed input element with the name '" + $(this).attr("name") + "' with the 'rel' attribute that must be less than a column count - " + iColumnCount, "add");
                    else {
                        if (this.nodeName.toLowerCase() == "select" || this.tagName.toLowerCase() == "select")
                            sCellValue = $("option:selected", this).text();
                        else if (this.nodeName.toLowerCase() == "span" || this.tagName.toLowerCase() == "span")
                            sCellValue = $(this).html();
                        else
                            sCellValue = this.value;

                        sCellValue = sCellValue.replace(properties.sIDToken, data);
                        values[rel] = sCellValue;
                    }
                });

                //Add values from the form into the table
                var rtn = oTable.fnAddData(values);
                var oTRAdded = oTable.fnGetNodes(rtn);
                //Apply editable plugin on the cells of the table
                _fnApplyEditable(oTRAdded);
                //add id returned by server page as an TR id attribute
                properties.fnSetRowID($(oTRAdded), data);
                //Close the dialog
                oAddNewRowForm.dialog('close');
                $(oAddNewRowForm)[0].reset();
                $(".error", $(oAddNewRowForm)).html("");

                _fnSetDisplayStart();
                properties.fnOnAdded("success");
            }
        }

        //Called when user cancels adding new record in the popup dialog
        function _fnOnCancelRowAdding(event) {
            //Clear the validation messages and reset form
            $(oAddNewRowForm).validate().resetForm();  // Clears the validation errors
            $(oAddNewRowForm)[0].reset();

            $(".error", $(oAddNewRowForm)).html("");
            $(".error", $(oAddNewRowForm)).hide();  // Hides the error element

            //Close the dialog
            oAddNewRowForm.dialog('close');
            event.stopPropagation();
            event.preventDefault();
        }

        function _fnDisableDeleteButton() {
            if (properties.oDeleteRowButtonOptions != null) {
                //oDelete takedit RowButton.disable();
                oDeleteRowButton.button("option", "disabled", true);
            } else {
                oDeleteRowButton.attr("disabled", "true");
            }
        }
		
		function _fnDisableUpdateRefButton() { //tak huapus
            if (properties.oUpdateRefRowButtonOptions != null) {
                oUpdateRefRowButton.button("option", "disabled", true);
            } else {
                oUpdateRefRowButton.attr("disabled", "true");
            }
        }		
		
		function _fnDisableBacaButton() {
            if (properties.oBacaRowButtonOptions != null) {
                //oDelete takedit RowButton.disable();
                oBacaRowButton.button("option", "disabled", true);
            } else {
                oBacaRowButton.attr("disabled", "true");
            }
        }		

        function _fnEnableDeleteButton() {
            if (properties.oDeleteRowButtonOptions != null) {
                //oDelete takedit RowButton.enable();
                oDeleteRowButton.button("option", "disabled", false);
            } else {
                oDeleteRowButton.removeAttr("disabled");
            }
        }
		
		function _fnEnableUpdateRefButton() {
            if (properties.oUpdateRefRowButtonOptions != null) {
                //oDelete takedit RowButton.enable();
                oUpdateRefRowButton.button("option", "disabled", false);
            } else {
                oUpdateRefRowButton.removeAttr("disabled");
            }
        }

		function _fnEnableBacaButton() {
            if (properties.oBacaRowButtonOptions != null) {
                //oDelete takedit RowButton.enable();
                oBacaRowButton.button("option", "disabled", false);
            } else {
                oBacaRowButton.removeAttr("disabled");
            }
        }		

        function _fnDeleteRow(id, sDeleteURL) {
            var sURL = sDeleteURL;			
			//alert(sURL+'--'+id);
            if (sDeleteURL == null)
                sURL = properties.sDeleteURL;
            properties.fnStartProcessingMode();
            var data = $.extend(properties.oDeleteParameters, { "id": id });
			//alert(data);
            $.ajax({ 'url': sURL,
                'type': properties.sDeleteHttpMethod,
                'data': data,
                "success": _fnOnRowDeleted,
                "dataType": "text",
                "error": function (response) {
                    properties.fnEndProcessingMode();
                    properties.fnShowError(response.responseText, "delete");
                    properties.fnOnDeleted("failure");

                }
            });
			window.opener.location.href = 'anjab_kandidat.php?reqId=' + properties.pSatkerId;
        }
		
		function _fnUpdateRefRow(id, sUpdateRowURL) {//tak huapus
            var sURL1 = sUpdateRowURL;
			//alert(sURL1);
			//alert(id);
            if (sUpdateRowURL == null)
                sURL1 = properties.sUpdateRowURL;
            properties.fnStartProcessingMode();
            var data = $.extend(properties.oDeleteParameters, { "id": id });
            $.ajax({ 'url': sURL1,
                'type': properties.sDeleteHttpMethod,
                'data': data,
                "success": _fnOnRowUpdatedRef,
                "dataType": "text",
                "error": function (response) {
                    properties.fnEndProcessingMode();
                    properties.fnShowError(response.responseText, "delete");
                    properties.fnOnUpdatedRow("failure");

                }
            });
        }

        //Called when user deletes a row
        function _fnOnRowDelete(event) {
            iDisplayStart = _fnGetDisplayStart();
            if ($('tr.' + properties.sSelectedRowClass + ' td', oTable).length == 0) {
                //oDelete takedit RowButton.attr("disabled", "true");
                _fnDisableDeleteButton();
                return;
            }
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			// tak hapus alert
			var mySplitResult = id.split("*");
			//alert(mySplitResult[0]+'--'+mySplitResult[2]+'--'+mySplitResult[3]);
			
			if(mySplitResult[2]==1 || mySplitResult[3]==1)
				alert('Data Tidak Bisa Di Hapus');				
			else{
				if (properties.fnOnDeleting($('tr.' + properties.sSelectedRowClass, oTable), id, _fnDeleteRow)) {
					_fnDeleteRow(id);
				}
			}
        }
		
		//Called when user deletes a row
        function _fnOnRowUpdateRef(event) {//tak huapus
            iDisplayStart = _fnGetDisplayStart();
            if ($('tr.' + properties.sSelectedRowClass + ' td', oTable).length == 0) {
                _fnDisableUpdateRefButton();
                return;
            }
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			// tak hapus alert 
			//var mySplitResult = id.split("/");
			//alert(mySplitResult[0]+'--'+mySplitResult[2]+'--'+mySplitResult[3]);
			
			//if(mySplitResult[2]==1 || mySplitResult[3]==1)
				//alert('Data Tidak Bisa Di Hapus');				
			//else{
				if (properties.fnOnUpdatingRefRow($('tr.' + properties.sSelectedRowClass, oTable), id, _fnUpdateRefRow)) {
					_fnUpdateRefRow(id);
				}
			//}
        }
		
		// onedha proses klik

        //Called when user KLIK BACA a row
        function _fnOnRowBaca(event) {
			fnReloadAjax('../json/daftar_urutan_pegawai_json.php?reqMode=proses&reqPangkatId=' + $("#pangkat").val() + '&reqTipePegawaiId=' + $("#filter").val() + '&reqId=' + properties.pSatkerId + '&reqBulan=' + $("#bulan").val() + '&reqTahun=' + $("#tahun").val());
        }
		
		//Called when user KLIK BACA a row
        function _fnOnRowBacaKeluar(event) {
			var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_entry_surat_keluar.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		function _fnOnCetakDuk(event) {
			var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 10;
			opHeight = 5;
			opUrl    = 'cetak_duk.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		//Called when user KLIK BACA a row
        function _fnOnRowBacaNotaDinas(event) {
			var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_entry_nota_dinas.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }

        //Called when user KLIK DISPOSISI a row
        function _fnOnRowDisposisi(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			//alert(id);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_disposisi.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		//Called when user KLIK DISPOSISI a row
        function _fnOnRowDisposisiNotaDinas(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			//alert(id);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_disposisi_nota_dinas.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		//Called when user KLIK Surat Keluar a row
        function _fnOnRowSuratKeluar(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_entry_surat_keluar_insert.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		function _fnOnRowLembarDisposisi(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'LembarDisposisi.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		function _fnOnRowTandaTerimaDisposisi(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'TandaTerimaEntry.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		function _fnOnRowEditNew(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_entry_surat_masuk_edit.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		function _fnOnRowEditKeluarNew(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_entry_surat_keluar_edit.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
		function _fnOnRowEditNotaDinas(event) {
            var id = fnGetCellID($('tr.' + properties.sSelectedRowClass + ' td', oTable)[0]);
			opWidth = 1050;
			opHeight = 550;
			opUrl    = 'pop_entry_nota_dinas_edit.php?reqJsonId='+id;
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2);
			newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
			newWindow.focus();			
        }
		
        //Called when record is deleted on the server
        function _fnOnRowDeleted(response) {
            properties.fnEndProcessingMode();
            var oTRSelected = $('tr.' + properties.sSelectedRowClass, oTable)[0];
            if (response == "ok" || response == "") {
                oTable.fnDeleteRow(oTRSelected);
                //oDelete takedit RowButton.attr("disabled", "true");
                _fnDisableDeleteButton();
                _fnSetDisplayStart();
                properties.fnOnDeleted("success");
            }
            else {
                properties.fnShowError(response, "delete");
                properties.fnOnDeleted("failure");
            }
        }
		
		function _fnOnRowUpdatedRef(response) {//tak huapus
            properties.fnEndProcessingMode();
            var oTRSelected = $('tr.' + properties.sSelectedRowClass, oTable)[0];
            if (response == "ok" || response == "") {
				//alert(response);
                oTable.fnDeleteRow(oTRSelected);
				//oTable.fnUpdateRefRow(oTRSelected);
				
                _fnDisableUpdateRefButton();
                _fnSetDisplayStart();
                properties.fnOnUpdatedRow("success");
            }
            else {
                properties.fnShowError(response, "delete");
                properties.fnOnUpdatedRow("failure");
            }
        }

        //Called before row is deleted
        //Returning false will abort delete
        /*
        * Function called before row is deleted
        * @param    tr  JQuery wrapped around the TR tag that will be deleted
        * @param    id  id of the record that wil be deleted
        * @return   true if plugin should continue with deleting row, false will abort delete.
        */
        function fnOnDeleting(tr, id, fnDeleteRow) {
			//alert(id);
            return confirm("Apakah anda yakin ingin memilih pegawai terpilih sebagai kandidat?"); ;
        }
		
		function fnOnUpdatingRefRow(tr, id, fnUpdateRefRow) {//tak huapus
			//alert(id);
            return confirm("Yakin Revisi Surat?"); ;
        }

        /* Function called after delete action
        * @param    result  string 
        *           "success" if row is actually deleted 
        *           "failure" if delete failed
        * @return   void
        */
        function fnOnDeleted(result) { }

        function fnOnEditing(input) { return true; }
        function fnOnEdited(result, sOldValue, sNewValue, iRowIndex, iColumnIndex, iRealColumnIndex) {

        }
		
		function fnOnUpdatedRow(result) { }//tak huapus

        function fnOnEditing(input) { return true; }
        function fnOnEdited(result, sOldValue, sNewValue, iRowIndex, iColumnIndex, iRealColumnIndex) {

        }

        function fnOnAdding() { return true; }
        function fnOnAdded(result) { }

        var oSettings;
        function _fnGetDisplayStart() {
            return oSettings._iDisplayStart;
        }

        function _fnSetDisplayStart() {
            if (oSettings.oFeatures.bServerSide === false) {
                oSettings._iDisplayStart = iDisplayStart;
                oSettings.oApi._fnCalculateEnd(oSettings);
                //draw the 'current' page
                oSettings.oApi._fnDraw(oSettings);
            }
        }


        oTable = this;
        var defaults = {
			pAddAttribut: {},
			pSatkerId: "", 
			pPeriodeBulan: "",
			pPeriodeTahun: "",			
            sUpdateURL: "UpdateData",
            sAddURL: "AddData",
            sDeleteURL: "DeleteData",
			//sUpdateRowURL: "DeleteData",
            sAddNewRowFormId: "formAddNewRow",
            oAddNewRowFormOptions: { autoOpen: false, modal: true },
            sAddNewRowButtonId: "btnAddNewRow",
            oAddNewRowButtonOptions: null,
            sAddNewRowOkButtonId: "btnAddNewRowOk",
            sAddNewRowCancelButtonId: "btnAddNewRowCancel",
            oAddNewRowOkButtonOptions: { label: "Ok" },
            oAddNewRowCancelButtonOptions: { label: "Cancel" },
            sDeleteRowButtonId: "btnDeleteRow",
			sUpdateRefRowButtonId: "btnUpdateRefRow",
            oDeleteRowButtonOptions: null,
			oUpdateRefRowButtonOptions: null,//tak huapus
			sBacaRowButtonId: "btnBacaRow",
            oBacaRowButtonOptions: null,
			/* onedha first declare by id */
			sBacaNotaDinasRowButtonId: "btnBacaNotaDinasRow",
			sBacaKeluarRowButtonId: "btnBacaKeluarRow",
			sDisposisiRowButtonId: "btnDisposisiRow",
			sDisposisiNotaDinasRowButtonId: "btnDisposisiNotaDinasRow",
			sSuratKeluarRowButtonId: "btnSuratKeluarRow",
			sLembarDisposisiButtonId: "btnLembarDisposisiRow",
			sTandaTerimaDisposisiButtonId: "btnTandaTerimaDisposisiRow",			
			sEditEntryMasukButtonId: "btnEditEntryMasukRow",
			sEditEntryKeluarButtonId: "btnEditEntryKeluarRow",
			sEditNotaDinasButtonId: "btnEditNotaDinasRow", 
            sSelectedRowClass: "row_selected",
            sReadOnlyCellClass: "read_only",
            sAddDeleteToolbarSelector: ".add_delete_toolbar",
            fnShowError: fnShowError,
            fnStartProcessingMode: fnStartProcessingMode,
            fnEndProcessingMode: fnEndProcessingMode,
            aoColumns: null,
            fnOnDeleting: fnOnDeleting,
			fnOnUpdatingRefRow: fnOnUpdatingRefRow, //tak huapus
            fnOnDeleted: fnOnDeleted,
			fnOnUpdatedRow: fnOnUpdatedRow, //tak huapus
            fnOnAdding: fnOnAdding,
            fnOnNewRowPosted: _fnOnNewRowPosted,
            fnOnAdded: fnOnAdded,
            fnOnEditing: fnOnEditing,
            fnOnEdited: fnOnEdited,
            sAddHttpMethod: 'POST',
            sDeleteHttpMethod: 'POST',
            fnGetRowID: _fnGetRowIDFromAttribute,
            fnSetRowID: _fnSetRowIDInAttribute,
            sEditorHeight: "100%",
            sEditorWidth: "100%",
            bDisableEditing: false,
            oDeleteParameters: {},
            sIDToken: "DATAROWID"

        };

        properties = $.extend(defaults, options);
        oSettings = oTable.fnSettings();

        return this.each(function () {

            if (oTable.fnSettings().sAjaxSource != null) {
                oTable.fnSettings().aoDrawCallback.push({
                    "fn": function () {
                        //Apply jEditable plugin on the table cells
                        _fnApplyEditable(oTable.fnGetNodes());
                        $(oTable.fnGetNodes()).each(function () {
                            var position = oTable.fnGetPosition(this);
                            var id = oTable.fnGetData(position)[0];
                            properties.fnSetRowID($(this), id);
                        }
                        );
                    },
                    "sName": "fnApplyEditable"
                });

            } else {
                //Apply jEditable plugin on the table cells
                _fnApplyEditable(oTable.fnGetNodes());
            }

            //Setup form to open in dialog
            oAddNewRowForm = $("#" + properties.sAddNewRowFormId);
            if (oAddNewRowForm.length != 0) {
                if (properties.oAddNewRowFormOptions != null) {
                    properties.oAddNewRowFormOptions.autoOpen = false;
                } else {
                    properties.oAddNewRowFormOptions = { autoOpen: false };
                }
                oAddNewRowForm.dialog(properties.oAddNewRowFormOptions);

                //Add button click handler on the "Add new row" button
                oAddNewRowButton = $("#" + properties.sAddNewRowButtonId);
                if (oAddNewRowButton.length != 0) {
                    oAddNewRowButton.click(function () {
						/* KETIKA TOMBOL ADD DITEKAN */
						if(properties.pAddAttribut.opWidth == null)
							window.top.location.href = properties.pAddAttribut.opUrl;
						else
						{
							var left = (screen.width/2)-(properties.pAddAttribut.opWidth/2);
							var top = (screen.height/2)-(properties.pAddAttribut.opHeight/2);
							newWindow = window.open(properties.pAddAttribut.opUrl, "", "width = " + properties.pAddAttribut.opWidth + "px, height = " + properties.pAddAttribut.opHeight + "px, resizable = 1, scrollbars, top="+top+", left="+left);
							newWindow.focus();
						}
                    });
                } else {
                    if ($(properties.sAddDeleteToolbarSelector).length == 0) {
                        throw "Cannot find a button with an id '" + properties.sAddNewRowButtonId + "', od placeholder with an id '" + properties.sAddDeleteToolbarSelector + "' that should be used for adding new row although form for adding new record is specified";
                    } else {
                        oAddNewRowButton = null; //It will be auto-generated later
                    }
                }

                //Prevent Submit handler
                if (oAddNewRowForm[0].nodeName.toLowerCase() == "form") {
                    oAddNewRowForm.unbind('submit');
                    oAddNewRowForm.submit(function (event) {
                        _fnOnRowAdding(event);
                        return false;
                    });
                } else {
                    $("form", oAddNewRowForm[0]).unbind('submit');
                    $("form", oAddNewRowForm[0]).submit(function (event) {
                        _fnOnRowAdding(event);
                        return false;
                    });
                }

                // array to add default buttons to
                var aAddNewRowFormButtons = [];

                oConfirmRowAddingButton = $("#" + properties.sAddNewRowOkButtonId, oAddNewRowForm);
                if (oConfirmRowAddingButton.length == 0) {
                    //If someone forgotten to set the button text
                    if (properties.oAddNewRowOkButtonOptions.text == null
                        || properties.oAddNewRowOkButtonOptions.text == "") {
                        properties.oAddNewRowOkButtonOptions.text = "Ok";
                    }
                    properties.oAddNewRowOkButtonOptions.click = _fnOnRowAdding;
                    properties.oAddNewRowOkButtonOptions.id = properties.sAddNewRowOkButtonId;
                    // push the add button onto the array
                    aAddNewRowFormButtons.push(properties.oAddNewRowOkButtonOptions);
                } else {
                    oConfirmRowAddingButton.click(_fnOnRowAdding);
                }

                oCancelRowAddingButton = $("#" + properties.sAddNewRowCancelButtonId);
                if (oCancelRowAddingButton.length == 0) {
                    //If someone forgotten to the button text
                    if (properties.oAddNewRowCancelButtonOptions.text == null
                        || properties.oAddNewRowCancelButtonOptions.text == "") {
                        properties.oAddNewRowCancelButtonOptions.text = "Cancel";
                    }
                    properties.oAddNewRowCancelButtonOptions.click = _fnOnCancelRowAdding;
                    properties.oAddNewRowCancelButtonOptions.id = properties.sAddNewRowCancelButtonId;
                    // push the cancel button onto the array
                    aAddNewRowFormButtons.push(properties.oAddNewRowCancelButtonOptions);
                } else {
                    oCancelRowAddingButton.click(_fnOnCancelRowAdding);
                }
                // if the array contains elements, add them to the dialog
                if (aAddNewRowFormButtons.length > 0) {
                    oAddNewRowForm.dialog('option', 'buttons', aAddNewRowFormButtons);
                }
                //Issue: It cannot find it with this call:
                //oConfirmRowAddingButton = $("#" + properties.sAddNewRowOkButtonId, oAddNewRowForm);
                //oCancelRowAddingButton = $("#" + properties.sAddNewRowCancelButtonId, oAddNewRowForm);
                oConfirmRowAddingButton = $("#" + properties.sAddNewRowOkButtonId);
                oCancelRowAddingButton = $("#" + properties.sAddNewRowCancelButtonId);
            } else {
                oAddNewRowForm = null;
            }

            //Set the click handler on the "Delete selected row" button
            oDeleteRowButton = $('#' + properties.sDeleteRowButtonId);
            if (oDeleteRowButton.length != 0)
                oDeleteRowButton.click(_fnOnRowDelete);
            else {
                oDeleteRowButton = null;
            }
			
			oUpdateRefRowButton = $('#' + properties.sUpdateRefRowButtonId);
            if (oUpdateRefRowButton.length != 0)
                oUpdateRefRowButton.click(_fnOnRowUpdateRef);
            else {
                oUpdateRefRowButton = null;
            }
			
			// onedha set klik
			
			//Set the click handler on the "Delete selected row" button
            oBacaRowButton = $('#' + properties.sBacaRowButtonId);
            if (oBacaRowButton.length != 0)
			{
                oBacaRowButton.click(_fnOnRowBaca);
			}
            else {
                oBacaRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button 
            oBacaKeluarRowButton = $('#' + properties.sBacaKeluarRowButtonId);
            if (oBacaKeluarRowButton.length != 0)
			{
                oBacaKeluarRowButton.click(_fnOnRowBacaKeluar);
			}
            else {
                oBacaKeluarRowButton = null;
            }
			
			oCetakDukButton = $('#btnCetakDuk');
            if (oCetakDukButton.length != 0)
			{
                oCetakDukButton.click(_fnOnCetakDuk);
			}
            else {
                oCetakDukButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oBacaNotaDinasRowButton = $('#' + properties.sBacaNotaDinasRowButtonId);
            if (oBacaNotaDinasRowButton.length != 0)
			{
                oBacaNotaDinasRowButton.click(_fnOnRowBacaNotaDinas);
			}
            else {
                oBacaNotaDinasRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oDisposisiRowButton = $('#' + properties.sDisposisiRowButtonId);
            if (oDisposisiRowButton.length != 0)
			{
                oDisposisiRowButton.click(_fnOnRowDisposisi);
			}
            else {
                oDisposisiRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oDisposisiNotaDinasRowButton = $('#' + properties.sDisposisiNotaDinasRowButtonId);
            if (oDisposisiNotaDinasRowButton.length != 0)
			{
                oDisposisiNotaDinasRowButton.click(_fnOnRowDisposisiNotaDinas);
			}
            else {
                oDisposisiNotaDinasRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oSuratKeluarRowButton = $('#' + properties.sSuratKeluarRowButtonId);
            if (oSuratKeluarRowButton.length != 0)
			{
                oSuratKeluarRowButton.click(_fnOnRowSuratKeluar);
			}
            else {
                oSuratKeluarRowButton = null;
            }			
			
			//Set the click handler on the "Delete selected row" button
            oLembarDisposisiRowButton = $('#' + properties.sLembarDisposisiButtonId);
            if (oLembarDisposisiRowButton.length != 0)
			{
                oLembarDisposisiRowButton.click(_fnOnRowLembarDisposisi);
			}
            else {
                oLembarDisposisiRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button 
            oTandaTerimaDisposisiRowButton = $('#' + properties.sTandaTerimaDisposisiButtonId);
            if (oTandaTerimaDisposisiRowButton.length != 0)
			{
                oTandaTerimaDisposisiRowButton.click(_fnOnRowTandaTerimaDisposisi);
			}
            else {
                oTandaTerimaDisposisiRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oEditEntryMasukRowButton = $('#' + properties.sEditEntryMasukButtonId);
            if (oEditEntryMasukRowButton.length != 0)
			{
                oEditEntryMasukRowButton.click(_fnOnRowEditNew);
			}
            else {
                oEditEntryMasukRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oEditEntryKeluarRowButton = $('#' + properties.sEditEntryKeluarButtonId);
            if (oEditEntryKeluarRowButton.length != 0)
			{
                oEditEntryKeluarRowButton.click(_fnOnRowEditKeluarNew);
			}
            else {
                oEditEntryKeluarRowButton = null;
            }
			
			//Set the click handler on the "Delete selected row" button
            oEditNotaDinasRowButton = $('#' + properties.sEditNotaDinasButtonId);
            if (oEditNotaDinasRowButton.length != 0)
			{
                oEditNotaDinasRowButton.click(_fnOnRowEditNotaDinas);
			}
            else {
                oEditNotaDinasRowButton = null;
            }
			
            //If an add and delete buttons does not exists but Add-delete toolbar is specificed
            //Autogenerate these buttons
            oAddDeleteToolbar = $(properties.sAddDeleteToolbarSelector);
            if (oAddDeleteToolbar.length != 0) {
				
				oAddDeleteToolbar.append("&nbsp;&nbsp;&nbsp;Tipe <select id='filter'><option value='1'>Struktural</option><option value='2'>Fungsional</option><option value=''>Semua</option></select>");	
				oFilterRowSelect = $("#filter");
							
				oFilterRowSelect.change(function () { 
					//alert('../json/anjab_kandidat_json.php?reqSatkerId=' + properties.pSatkerId + '&reqMode=' + $("#filter").val());	
					/* Example call to load a new file */
					fnReloadAjax('../json/daftar_urutan_pegawai_json.php?reqPangkatId=' + $("#pangkat").val() + '&reqTipePegawaiId=' + $("#filter").val() + '&reqId=' + properties.pSatkerId + '&reqBulan=' + $("#bulan").val() + '&reqTahun=' + $("#tahun").val());
				});
				
				var currentTime = new Date();
				oAddDeleteToolbar.append("&nbsp;Periode <select id='bulan'><option value='01'>Januari</option><option value='02'>Februari</option><option value='03'>Maret</option><option value='04'>April</option><option value='05'>Mei</option><option value='06'>Juni</option><option value='07'>Juli</option><option value='08'>Agustus</option><option value='09'>September</option><option value='10'>Oktober</option><option value='11'>November</option><option value='12'>Desember</option></select> <select id='tahun'></select> &nbsp;&nbsp;");
				oBulanRowSelect = $("#bulan");
				var bulan_sekarang = "";
				if(currentTime.getMonth() + 1 < 10)
					bulan_sekarang = "0" + (currentTime.getMonth() + 1);
				else
					bulan_sekarang = currentTime.getMonth() + 1;
				$("#bulan").val(bulan_sekarang);
				
				oTahunRowSelect = $("#tahun");
				for(i=currentTime.getFullYear() - 2;i<=currentTime.getFullYear() + 2; i++)
				{
					$("<option value='" + i + "'>" + i + "</option>").appendTo("#tahun");			
				}
				$("#tahun").val(currentTime.getFullYear());
				
				oAddDeleteToolbar.append("Gol.Ruang <select id='pangkat'><option value=''>Semua</option></select>"); 
				oPangkatRowSelect = $("#pangkat");
				$.getJSON("../json/pangkat_lookup_json.php",
				function(data){
					for(i=0;i<data.PANGKAT_ID.length; i++)
					{
					$("<option value='" + data.KODE[i] + "'>" + data.KODE[i] + "</option>").appendTo("#pangkat"); 
					} 
				});
				oPangkatRowSelect.change(function () { 
					properties.pPeriodeBulan = $("#bulan").val();
					properties.pPeriodeTahun = $("#tahun").val();
					
					fnReloadAjax('../json/daftar_urutan_pegawai_json.php?reqPangkatId=' + $("#pangkat").val() + '&reqTipePegawaiId=' + $("#filter").val() + '&reqId=' + properties.pSatkerId + '&reqBulan=' + $("#bulan").val() + '&reqTahun=' + $("#tahun").val());
				});
				
				oBulanRowSelect.change(function () { 
					//alert($("#pilihan").val());	
					/* Example call to load a new file */
					properties.pPeriodeBulan = $("#bulan").val();
					properties.pPeriodeTahun = $("#tahun").val();
					fnReloadAjax('../json/daftar_urutan_pegawai_json.php?reqPangkatId=' + $("#pangkat").val() + '&reqTipePegawaiId=' + $("#filter").val() + '&reqId=' + properties.pSatkerId + '&reqBulan=' + $("#bulan").val() + '&reqTahun=' + $("#tahun").val());
				});
				
				oTahunRowSelect.change(function () { 
					//alert($("#pilihan").val());	
					/* Example call to load a new file */
					properties.pPeriodeBulan = $("#bulan").val();
					properties.pPeriodeTahun = $("#tahun").val();
					fnReloadAjax('../json/daftar_urutan_pegawai_json.php?reqPangkatId=' + $("#pangkat").val() + '&reqTipePegawaiId=' + $("#filter").val() + '&reqId=' + properties.pSatkerId + '&reqBulan=' + $("#bulan").val() + '&reqTahun=' + $("#tahun").val());
				});
												
            }
			
			function fnShowHide( iCol )
			{
				/* Get the DataTables object again - this is not a recreation, just a get of the object */
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol,false);
			}			

			fnReloadAjax = function (sNewSource)
			{	
				if ( typeof sNewSource != 'undefined' && sNewSource != null )
				{
					oSettings.sAjaxSource = sNewSource;
				}
				var that = oTable;
				var iStart = oSettings._iDisplayStart;
				that.oApi._fnProcessingDisplay( oSettings, true );
				
				oSettings.fnServerData( oSettings.sAjaxSource, [], function(json) {
					/* Clear the old information from the table */
					that.oApi._fnClearTable( oSettings );
					
					/* Got the data - add it to the table */
					for ( var i=0 ; i<json.aaData.length ; i++ )
					{
						that.oApi._fnAddData( oSettings, json.aaData[i] );
					}
					
					oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
					that.fnDraw();
					
					if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
					{
						oSettings._iDisplayStart = iStart;
						that.fnDraw( false );
					}
					
					that.oApi._fnProcessingDisplay( oSettings, false );
					
					/* Callback user function - for event handlers etc */
					if ( typeof fnCallback == 'function' && fnCallback != null )
					{
						fnCallback( oSettings );
					}
				}, oSettings );
			}
			
            //If delete button exists disable it until some row is selected
            if (oDeleteRowButton != null) {
                if (properties.oDeleteRowButtonOptions != null) {
                    oDeleteRowButton.button(properties.oDeleteRowButtonOptions);
                }
                _fnDisableDeleteButton();
            }
			
			//If delete button exists disable it until some row is selected
            if (oUpdateRefRowButton != null) { //tak huapus
                if (properties.oUpdateRefRowButtonOptions != null) {
                    oUpdateRefRowButton.button(properties.oUpdateRefRowButtonOptions);
                }
                _fnDisableUpdateRefButton();
            }
			
            //If delete button exists disable it until some row is selected
            if (oBacaRowButton != null) {
                if (properties.oBacaRowButtonOptions != null) {
                    oBacaRowButton.button(properties.oBacaRowButtonOptions);
                }
                _fnDisableBacaButton();
            }

            //If add button exists convert it to the JQuery-ui button
            if (oAddNewRowButton != null) {
                if (properties.oAddNewRowButtonOptions != null) {
                    oAddNewRowButton.button(properties.oAddNewRowButtonOptions);
                }
            }


            //If form ok button exists convert it to the JQuery-ui button
            if (oConfirmRowAddingButton != null) {
                if (properties.oAddNewRowOkButtonOptions != null) {
                    oConfirmRowAddingButton.button(properties.oAddNewRowOkButtonOptions);
                }
            }

            //If form cancel button exists convert it to the JQuery-ui button
            if (oCancelRowAddingButton != null) {
                if (properties.oAddNewRowCancelButtonOptions != null) {
                    oCancelRowAddingButton.button(properties.oAddNewRowCancelButtonOptions);
                }
            }

            //Add handler to the inline delete buttons
            $(".table-action-deletelink", oTable).live("click", function (e) {

                    e.preventDefault();
                    e.stopPropagation();
                    var sURL = $(this).attr("href");
					var sURL1 = $(this).attr("href");
					//alert(sURL+'--'+sURL1)

                    if (sURL == null || sURL == "")
                        sURL = properties.sDeleteURL;
					
					if (sURL1 == null || sURL1 == "")
                        sURL1 = properties.sUpdateRowURL;

                    iDisplayStart = _fnGetDisplayStart();
                    var oTD = ($(this).parents('td'))[0];
                    var oTR = ($(this).parents('tr'))[0];

                    $(oTR).addClass(properties.sSelectedRowClass);

                    var id = fnGetCellID(oTD);
                    if (properties.fnOnDeleting(oTD, id, _fnDeleteRow)) {
						//alert(id);
                        _fnDeleteRow(id, sURL);
                    }
					if (properties.fnOnUpdatingRefRow(oTD, id, _fnUpdateRefRow)) {
						//alert(id);
                        _fnUpdateRefRow(id, sURL1);
                    }


                }
            );

            //Set selected class on row that is clicked
            //Enable delete button if row is selected, disable delete button if selected class is removed
            $("tbody", oTable).click(function (event) {
                if ($(event.target.parentNode).hasClass(properties.sSelectedRowClass)) {
                    $(event.target.parentNode).removeClass(properties.sSelectedRowClass);
                    if (oDeleteRowButton != null) {
                        _fnDisableDeleteButton();
                    }
					if (oUpdateRefRowButton != null) {
                        _fnDisableUpdateRefButton();
                    }
					if (oBacaRowButton != null) {
                        _fnDisableBacaButton();
                    }
                } else {
                    $(oTable.fnSettings().aoData).each(function () {
                        $(this.nTr).removeClass(properties.sSelectedRowClass);
                    });
                    $(event.target.parentNode).addClass(properties.sSelectedRowClass);
                    if (oDeleteRowButton != null) {
                        _fnEnableDeleteButton();
                    }
					if (oUpdateRefRowButton != null) {
                        _fnEnableUpdateRefButton();
                    }
                    if (oBacaRowButton != null) {
                        _fnEnableBacaButton();
                    }
                }
            });



        });
    };
})(jQuery);
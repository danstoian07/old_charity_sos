<?php

class tab_upload_multiple_type_files extends tab_upload {
	public  $upload_table_name                    	= 'gallery';						/* table in witch will be stored uploaded files info (without app prefix) */	
	public  $upload_permission_add_item            	= 1;								/* users can add file for upload */	
	public  $upload_permission_delete_item         	= 1;								/* users can delete file */			
	public  $upload_accepted_file_type     			= array(
														array('Image files','jpg,gif,png,jpeg,tiff'),													
														array('Archive files','zip,arj,ace,rar'),
														array('PDF files','pdf'),
														array('MS Word files','doc,docx'),
														array('MS Excel files','xls,xlsx'),
														array('Movie files','mp4,avi,mpeg'),
														array('Audio files','mp3,wav'),
													);	/* bidimensional array with accepted files type for upload. Ex: (('Graphical file', 'jpg, bmp, tiff'),('Archive file', 'zip, arj, rar'), ...) */	
												
	
	/* ------------------------------------------------------------------------------------- */	
	public function ReturnTabContent($arr_fields, $result_line='', $result_multiselect='', $tab_no=0) {    
		$tab_content = '
                                                    <!--
													<div class="alert alert-success margin-bottom-10">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <i class="fa fa-warning fa-lg"></i> Image type and information need to be specified. 
													</div>
													-->
                                                    '.($this->upload_permission_add_item ? '
													<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
                                                        <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn btn-success">
                                                            <i class="fa fa-plus"></i> Selecteaza Fisiere </a>
                                                        <a id="tab_images_uploader_uploadfiles" href="javascript:;" class="btn btn-primary">
                                                            <i class="fa fa-upload"></i> Upload Fisiere </a>
                                                    </div>													
                                                    <div class="row">
                                                        <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"> </div>
                                                    </div>
													<hr class="hr3">' : '').'
                                    <div class="table-container">										
                                        <div class="table-actions-wrapper">
                                            <span> </span>
                                            <select class="table-group-action-input form-control input-inline input-small input-sm">
                                                <option value="">Actiuni globale</option>
												'.$this->ReturnGlobalActionsString().'
                                            </select>
                                            <button class="btn btn-sm green table-group-action-submit">
                                                <i class="fa fa-check"></i> Executa</button>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_upload" table-upload="'.el_encript_info($this->upload_table_name).'" >
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th width="2%">
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                                            <span></span>
                                                        </label>
                                                    </th>
                                                    
                                                    <th width="10%"> Data adaugarii</th>
													<th width="5%"> Preview</th>
													<th width="10%"> Fisier</th>
                                                    <th width="20%"> Descriere </th>
                                                    <th width="5%"> Dim </th>
                                                    <th width="15%"> Actiuni </th>
                                                </tr>
                                                <tr role="row" class="filter">
                                                    <td> </td>
                                                    <td>
                                                        <div class="input-group date date-picker margin-bottom-5" data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control form-filter input-sm" readonly name="filter_date_1" placeholder="De la">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-sm default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control form-filter input-sm" readonly name="filter_date_2" placeholder="La">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-sm default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </td>
													<td> </td>
                                                    <td><input type="text" class="form-control form-filter input-sm" name="file_name"> </td>
													<td><input type="text" class="form-control form-filter input-sm" name="file_description"> </td>
                                                    <td> </td>
                                                    <td>
                                                        <!--<div class="margin-bottom-5">-->
                                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="filter_gallery">
                                                                <i class="fa fa-search"></i> Filtreaza</button>
                                                        <!--</div>-->
                                                        <button class="btn btn-sm red btn-outline filter-cancel">
                                                            <i class="fa fa-times"></i> Resetare</button>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody> </tbody>
                                        </table>
                                    </div><!-- ************** -->
													
													';
		
		return $tab_content;
	}
	/* ------------------------------------------------------------------------------------- */	
	public function __construct() {
		parent::__construct();		
	}	
	/* ------------------------------------------------------------------------------------- */	
}
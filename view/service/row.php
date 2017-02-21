              <td>
                <?echo $c+0;?>
              </td>
              <td>
                <?echo $val->parent;?>
              </td>
                <td>
                <?echo $val->service_id;?>
              </td>
              <td>
                <i class="fa <?if ($val->icon) {echo $val->icon;} 
                elseif ($val->type=="service") {echo "fa-cloud";} 
                else {echo "fa-folder";}?>"></i>              
                <?echo $doc->lnk($_SERVER['SCRIPT_NAME']."?parent=$val->service_id",$val->caption);?>
              </td>
                <td>
                <?echo $doc->lnk($val->link);?>
              </td>
            <td class="text-center">
                <?echo $val->apikey;?>
              </td>  
              <td class="text-center" data-value="status_<?echo $val->status;?>">
                  <?switch ($val->status) {
                case "pending":$label="warning";break;
                case "active":$label="success";break;
                case "suspended":$label="danger";break;
                default:$label="default";break;
            }?>
                <span class="label label-<?echo $label;?>"><?echo $val->status;?></span>
              </td>  
                <td class="text-center">
                <?echo $val->date_inserted;?>
              </td>
              <td>
                <?echo $val->v_order;?>
              </td> 
                <td class="text-center">
                    <a href="<?echo $_SERVER['SCRIPT_NAME'];?>?cmd=edit&<?echo $pageID;?>_id=<?echo $val->{$pageID."_id"}?>" class="table-link" target="iframer">
                      <span class="fa-stack">
                        <i class="fa fa-square fa-stack-2x"></i>
                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                      </span>
                    </a>
                <?if (!$main->confirm_delete($val->service_id)) {?>
                    <a href="#remove<?echo $pageID;?>" data-toggle="modal" data-<?echo $pageID;?>_id="<?echo $val->{$pageID."_id"};?>" data-item="<?echo $val->caption;?>" class="table-link danger">
                      <span class="fa-stack">
                        <i class="fa fa-square fa-stack-2x"></i>
                        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                      </span>
                    </a>
                    <a class="row-delete" href="#" id="del_<?echo $pageID;?>_<?echo $val->{$pageID."_id"};?>"></a>
                <?} else {?>
                    <a href="#removesubservice" data-toggle="modal" class="table-link danger">
                      <span class="fa-stack">
                        <i class="fa fa-square fa-stack-2x"></i>
                        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                      </span>
                    </a>
                <?}?>
                </td>
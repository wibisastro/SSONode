  <td><?echo $c+1;?></td>
  <td><?echo $val->account_id;?></td>
  <td>            
    <?echo $val->fullname;?>
  </td>
  <td>            
    <?echo $val->email;?>
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
    <a href="<?echo $_SERVER['SCRIPT_NAME'];?>?cmd=edit&no=<?echo $c;?>&<?echo $pageID;?>_id=<?echo $val->{$pageID."_id"};?>" class="table-link" target="iframer">
      <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
      </span>
    </a>
    <a href="#change<?echo $pageID;?>" data-toggle="modal" data-<?echo $pageID;?>_id="<?echo $val->{$pageID."_id"};?>" data-item="<?echo $val->fullname;?>" class="table-link danger">
      <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-gear fa-stack-1x fa-inverse"></i>
      </span>
    </a>
    <!-- <a href="#reset<?echo $pageID;?>" data-toggle="modal" data-<?echo $pageID;?>_id="<?echo $val->{$pageID."_id"};?>" data-item="<?echo $val->fullname;?>" class="table-link danger">
      <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-refresh fa-stack-1x fa-inverse"></i>
      </span>
    </a> -->
    <a href="#remove<?echo $pageID;?>" data-toggle="modal" data-<?echo $pageID;?>_id="<?echo $val->{$pageID."_id"};?>" data-item="<?echo $val->fullname;?>" class="table-link danger">
      <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
      </span>
    </a>
    <a class="row-delete" href="#" id="del_<?echo $pageID;?>_<?echo $val->{$pageID."_id"};?>"></a>
  </td>


                
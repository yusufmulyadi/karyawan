

<?php
if(!function_exists('mysql_connect')) {
  define('MYSQL_CLIENT_COMPRESS',MYSQLI_CLIENT_COMPRESS);
  define('MYSQL_CLIENT_IGNORE_SPACE',MYSQLI_CLIENT_IGNORE_SPACE);
  define('MYSQL_CLIENT_INTERACTIVE',MYSQLI_CLIENT_INTERACTIVE);
  define('MYSQL_CLIENT_SSL',MYSQLI_CLIENT_SSL);
  define('MYSQL_ASSOC',MYSQLI_ASSOC);
  define('MYSQL_NUM',MYSQLI_NUM);
  define('MYSQL_BOTH',MYSQLI_BOTH);

  $GLOBALS['mysql_connect']=isset($GLOBALS['mysql_connect'])?$GLOBALS['mysql_connect']:false;
  $GLOBALS['mysql_db_result']=isset($GLOBALS['mysql_db_result'])?$GLOBALS['mysql_db_result']:false;
  $GLOBALS['mysql_db_name']=isset($GLOBALS['mysql_db_name'])?$GLOBALS['mysql_db_name']:array();
  $GLOBALS['mysql_tb_result']=isset($GLOBALS['mysql_tb_result'])?$GLOBALS['mysql_tb_result']:false;
  $GLOBALS['mysql_tb_name']=isset($GLOBALS['mysql_tb_name'])?$GLOBALS['mysql_tb_name']:array();

  function mysql_pconnect($host='',$user='',$pass='') {
    return $GLOBALS['mysql_connect']=mysqli_connect($host,$user,$pass);
  }

  function mysql_connect($host='',$user='',$pass='') {
    return $GLOBALS['mysql_connect']=mysqli_connect($host,$user,$pass);
  }

  function mysql_client_encoding($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_character_set_name($conn);
  }

  function mysql_set_charset($charset='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    if(!empty($charset) && $conn!==false) {return mysqli_set_charset($conn,$charset);}
    else {return false;}
  }

  function mysql_create_db($dbname='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    if(!empty($dbname) && !$conn && mysqli_query($conn,'CREATE DATABASE '.$dbname)) {return true;}
    else {return false;}
  }

  function mysql_drop_db($dbname='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    if(!empty($dbname) && !$conn && mysqli_query($conn,'DROP DATABASE '.$dbname)) {return true;}
    else {return false;}
  }

  function mysql_list_dbs($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_query($conn,'SHOW DATABASES');
  }

  function mysql_db_name($res=false,$row=0,$field=NULL) {
    if(!$GLOBALS['mysql_db_result'] || $GLOBALS['mysql_db_result']!=$res) {
      $GLOBALS['mysql_db_result']=$res;
      $GLOBALS['mysql_db_name']=array();
      /*
        Silakan pilih salah satu cara di bawah, ada beda di kecepatan jika datanya banyak.
        Nomer 3 dipilih HANYA karena bentuknya umum, bukan karena lebih cepat.
      */
      //for($i=0;$GLOBALS['mysql_db_name'][$i]=mysql_fetch_row($res)[0];$i++);unset($GLOBALS['mysql_db_name'][$i]);
      //while($GLOBALS['mysql_db_name'][]=mysql_fetch_row($res)[0]);array_pop($GLOBALS['mysql_db_name']);
      while($rec=mysql_fetch_row($res)) {$GLOBALS['mysql_db_name'][]=$rec[0];}
    }

    if($GLOBALS['mysql_db_result']!==false && $GLOBALS['mysql_db_result']==$res && isset($GLOBALS['mysql_db_name'][$row])) {
      return $GLOBALS['mysql_db_name'][$row];
    }
    else {return false;}
  }

  function mysql_list_tables($dbname='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    if(!empty($dbname) && !$conn) {return mysqli_query($conn,'SHOW TABLES FROM '.$dbname);}
    else {return false;}
  }

  function mysql_tablename($res=false,$row=false) {
    if(!$GLOBALS['mysql_tb_result'] || $GLOBALS['mysql_tb_result']!=$res) {
      $GLOBALS['mysql_tb_result']=$res;
      $GLOBALS['mysql_tb_name']=array();
      /*
        Silakan pilih salah satu cara di bawah, ada beda di kecepatan jika datanya banyak.
        Nomer 3 dipilih HANYA karena bentuknya umum, bukan karena lebih cepat.
      */
      //for($i=0;$GLOBALS['mysql_tb_name'][$i]=mysql_fetch_row($res)[0];$i++);unset($GLOBALS['mysql_tb_name'][$i]);
      //while($GLOBALS['mysql_tb_name'][]=mysql_fetch_row($res)[0]);array_pop($GLOBALS['mysql_tb_name']);
      while($rec=mysql_fetch_row($res)) {$GLOBALS['mysql_tb_name'][]=$rec[0];}
    }

    if($GLOBALS['mysql_tb_result']!==false && $GLOBALS['mysql_tb_result']==$res && isset($GLOBALS['mysql_tb_name'][$row])) {
      return $GLOBALS['mysql_tb_name'][$row];
    }
    else {return false;}
  }

  function mysql_list_fields($dbname='',$tbname='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    if(!empty($dbname) && !empty($tbname) && !$conn) {mysqli_query($conn,'SHOW COLUMNS FROM '.$dbname.'.'.$tbname);}
    else {return false;}
  }

  function mysql_select_db($dbname='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_select_db($conn,$dbname);
  }

  function mysql_db_query($dbname='',$query='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    mysqli_select_db($conn,$dbname);
    return mysqli_query($conn,$query);
  }

  function mysql_query($query='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_query($conn,$query);
  }

  function mysql_unbuffered_query($query='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_query($conn,$query,MYSQLI_USE_RESULT);
  }

  function mysql_errno($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_errno($conn);
  }

  function mysql_error($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_error($conn);
  }

  function mysql_close($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_close($conn);
  }

  function mysql_info($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_info($conn);
  }

  function mysql_ping($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_ping($conn);
  }

  function mysql_list_processes($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_query($conn,'SHOW PROCESSLIST');
  }

  function mysql_thread_id($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_thread_id($conn);
  }

  function mysql_stat($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_stat($conn);
  }

  function mysql_get_client_info($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_get_client_info($conn);
  }

  function mysql_get_host_info($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_get_host_info($conn);
  }

  function mysql_get_proto_info($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_get_proto_info($conn);
  }

  function mysql_get_server_info($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_get_server_info($conn);
  }

  function mysql_escape_string($str='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_real_escape_string($conn,$str);
  }

  function mysql_real_escape_string($str='',$conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_real_escape_string($conn,$str);
  }

  function mysql_affected_rows($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_affected_rows($conn);
  }

  function mysql_insert_id($conn=false) {
    if(!$conn) $conn=$GLOBALS['mysql_connect'];
    return mysqli_insert_id($conn);
  }

  function mysql_free_result($res=false) {
    return mysqli_free_result($res);
  }

  function mysql_num_fields($res=false) {
    return mysqli_num_fields($res);
  }

  function mysql_num_rows($res=false) {
    return mysqli_num_rows($res);
  }

  function mysql_fetch_array($res=false,$type=MYSQLI_BOTH) {
    return mysqli_fetch_array($res,$type);
  }

  function mysql_fetch_assoc($res=false) {
    return mysqli_fetch_assoc($res);
  }

  function mysql_fetch_row($res=false) {
    return mysqli_fetch_row($res);
  }

  function mysql_fetch_object($res=false,$class=null,$array=null) {
    return mysqli_fetch_object($res,$class,$array);
  }

  function mysql_data_seek($res=false,$num=false) {
    if($res!==false && $num!==false) {return mysqli_data_seek($res,$num);}
    else {return false;}
  }

  function mysql_field_seek($res=false,$offset=false) {
    if($res!==false && $offset!==false) {return mysqli_field_seek($res,$offset);}
    else {return false;}
  }

  function mysql_result($res=false,$row=false,$field=0) {
    if($res!==false && $row!==false) {
      mysqli_data_seek($res,$row);
      $rec=mysqli_fetch_row($res);
      if(isset($rec[$field])) {return $rec[$field];}
      else {return false;}
    }
    else {return false;}
  }

  function mysql_fetch_field($res=false,$offset=0) {
    return mysqli_fetch_field($res);
  }

  function mysql_fetch_lengths($res=false) {
    return mysqli_fetch_lengths($res);
  }

  function mysql_field_table($res=false,$offset=false) {
    if($res!==false && $offset!==false) {
      $rec=mysqli_fetch_field_direct($res,$offset);
      return isset($rec->orgtable)?$rec->orgtable:false;
    }
    else {return false;}
  }

  function mysql_field_name($res=false,$offset=false) {
    if($res!==false && $offset!==false) {
      $rec=mysqli_fetch_field_direct($res,$offset);
      return isset($rec->orgname)?$rec->orgname:false;
    }
    else {return false;}
  }

  function mysql_field_len($res=false,$offset=false) {
    if($res!==false && $offset!==false) {
      $rec=mysqli_fetch_field_direct($res,$offset);
      return isset($rec->length)?$rec->length:false;
    }
    else {return false;}
  }

  function mysql_field_flags($res=false,$offset=false) {
    if($res!==false && $offset!==false) {
      $rec=mysqli_fetch_field_direct($res,$offset);
      $rec=isset($rec->flags)?$rec->flags:false;
      $str=array();
      if($rec) {
        if($rec&MYSQLI_NOT_NULL_FLAG) $str[]='not_null';
        if($rec&MYSQLI_PRI_KEY_FLAG) $str[]='primary_key';
        if($rec&MYSQLI_UNIQUE_KEY_FLAG) $str[]='unique_key';
        if($rec&MYSQLI_MULTIPLE_KEY_FLAG) $str[]='multiple_key';
        if($rec&MYSQLI_BLOB_FLAG) $str[]='blob';
        if($rec&MYSQLI_UNSIGNED_FLAG) $str[]='unsigned';
        if($rec&MYSQLI_ZEROFILL_FLAG) $str[]='zerofill';
        if($rec&MYSQLI_BINARY_FLAG) $str[]='binary';
        if($rec&MYSQLI_ENUM_FLAG) $str[]='enum';
        if($rec&MYSQLI_AUTO_INCREMENT_FLAG) $str[]='auto_increment';
        if($rec&MYSQLI_TIMESTAMP_FLAG) $str[]='timestamp';
        if($rec&MYSQLI_SET_FLAG) $str[]='set';
        if($rec&MYSQLI_PART_KEY_FLAG) $str[]='multi_index';
        if($rec&MYSQLI_NUM_FLAG) $str[]='num';
        return implode(' ',$str);
      }
      else {return false;}
    }
    else {return false;}
  }

  function mysql_field_type($res=false,$offset=false) {
    if($res!==false && $offset!==false) {
      $rec=mysqli_fetch_field_direct($res,$offset);
      $rec=isset($rec->type)?$rec->type:false;
      if($rec) {
        switch($rec) {
          case MYSQLI_TYPE_DECIMAL : return 'decimal';break;
          case MYSQLI_TYPE_TINY : return 'tinyint';break;
          case MYSQLI_TYPE_SHORT : return 'smallint';break;
          case MYSQLI_TYPE_LONG : return 'integer';break;
          case MYSQLI_TYPE_FLOAT : return 'float';break;
          case MYSQLI_TYPE_DOUBLE : return 'double';break;
          case MYSQLI_TYPE_NULL : return 'default_null';break;
          case MYSQLI_TYPE_TIMESTAMP : return 'timestamp';break;
          case MYSQLI_TYPE_LONGLONG : return 'bigint';break;
          case MYSQLI_TYPE_INT24 : return 'mediumint';break;
          case MYSQLI_TYPE_DATE : return 'date';break;
          case MYSQLI_TYPE_TIME : return 'time';break;
          case MYSQLI_TYPE_DATETIME : return 'datetime';break;
          case MYSQLI_TYPE_YEAR : return 'year';break;
          case MYSQLI_TYPE_NEWDATE : return 'date';break;
          case MYSQLI_TYPE_BIT : return 'bit';break;
          case MYSQLI_TYPE_NEWDECIMAL : return 'numeric';break;
          case MYSQLI_TYPE_ENUM : return 'enum';break;
          case MYSQLI_TYPE_SET : return 'set';break;
          case MYSQLI_TYPE_TINY_BLOB : return 'tinyblob';break;
          case MYSQLI_TYPE_MEDIUM_BLOB : return 'mediumblob';break;
          case MYSQLI_TYPE_LONG_BLOB : return 'longblob';break;
          case MYSQLI_TYPE_BLOB : return 'blob';break;
          case MYSQLI_TYPE_VAR_STRING : return 'varchar';break;
          case MYSQLI_TYPE_STRING : return 'char';break;
          case MYSQLI_TYPE_GEOMETRY : return 'geometry';break;
          default : return $rec;break;
        }
      }
      else {return false;}
    }
    else {return false;}
  }
}
?>


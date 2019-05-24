<?php /*  @var $help HelperClass
 
 * 
 *  */

class sqlData {
    
  
    
    
  public $filename;
  public $filedesc;
  public $created;
  public $enums;
  public $classes;
  public $mn;
  public $filelist=array();
  
 
          
    public function findAll() {
        $dir    = 'files';
        $files = scandir($dir);
        $i=0;
        foreach($files as $file){
            $filedata=explode("_",$file);
            if($filedata[0]=="data"){
                $i++;
                $f = new sqlData();
                $f->filename = $file;
                $f->filedesc="Data ".$i;
                $f->created = Help::toDateTime($filedata[1]);
                $filedataExt = explode("-", $filedata[2]);
                $f->classes = $filedataExt[0];
                $f->enums = $filedataExt[1];
                $f->mn = $filedataExt[2];
                array_push($this->filelist, $f);
            }
            
          
        } 
        return $this->filelist;
    }
}
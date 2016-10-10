<?php

class LinkPager extends CLinkPager
{
                
    public $header = 'Страница: <input style="width: 2em;" id="PageNum" onkeypress="if(event.which == 13) $(\'#PageBtn\').click();" type="text"/> <input value="Перейти" id="PageBtn" onclick="$(\'.pager .previous a\').attr(\'href\',$(\'.pager .previous a\').attr(\'href\').replace(/&page=[0-9]+/g,\'\')+\'&page=\'+$(\'.pager #PageNum\').val()).click();" type="button"/> ';
    public $prevPageLabel = '&laquo; назад';
    public $nextPageLabel = 'далее &raquo;';
    
    protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();
                
                if ($pageCount<=17)
                    return parent::createPageButtons();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// prev page
		if ($this->prevPageLabel !== false) {
			if(($page=$currentPage-1)<0)
				$page=0;
			$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);
		}

		// первые страницы
		for($i=0;$i<=4;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
                
                $buttons[]='-';
                
                // промежуточные страницы
                if ($currentPage>=4&&$currentPage<$pageCount-4)
                {
                    if ($currentPage>$pageCount-9)
                    {
                    $start=$pageCount-10;
                    $end=$pageCount-6;   
                    }
                    else if ($currentPage>=7&&$currentPage<=$pageCount-6)
                    {
                    $start=$currentPage-2;
                    $end=$currentPage+2;
                    }
                    else
                    {
                    $start=5;
                    $end=9;
                    }
                    
                    for($i=$start;$i<=$end;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
                }
                else
                    for($i=ceil($pageCount/2)-2;$i<=ceil($pageCount/2)+2;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
                
                $buttons[]='-';
                
                // последние страницы
                for($i=$pageCount-5;$i<=$pageCount-1;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
		
		// next page
		if ($this->nextPageLabel !== false) {
			if(($page=$currentPage+1)>=$pageCount-1)
				$page=$pageCount-1;
			$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);
		}

		return $buttons;
	}
}
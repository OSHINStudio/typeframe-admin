<?php
$entries = new BaseModel_Log();
$entries->order('logid DESC');
$pagination = Pagination::Calculate($entries->getTotal(), 20);
$pm->setVariable('pagination', $pagination);
$entries->paginate($pagination['page'], 20);
$pm->setVariable('entries', $entries);

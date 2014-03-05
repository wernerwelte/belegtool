function update( col, value, id, filterID )
{   
    x1  = "document.vlvz.professor"     + id +".value";
    x2  = "document.vlvz.studiengang"   + id +".value";
    x3  = "document.vlvz.veranstaltung" + id +".value";
    sum = eval( x1 ) + "#"+ eval( x2 ) + "#"+ eval( x3 );
	
    document.param.sum.value = sum;
    document.param.col.value = col;
    document.param.val.value = value;
    document.param.id.value  = id;

	  document.param.submit();
}



function update2( col, value, id, matrikelnr, akennung, status, fID )
{   
	if( id )
	{
		veranstaltungID	 = eval("document.beleglisteGesamt.veranstaltung"+ id +".value");
		checksum = akennung  + ";" + veranstaltungID + ";"  + matrikelnr ;
	}
	
    document.param.col.value	    = col;
    document.param.val.value	    = value;
    document.param.id.value		    = id;
    document.param.status.value	  = status;
    document.param.filterID.value	= fID;

    document.param.checksum.value	= checksum 
    
	  document.param.submit();
}

function confirmSubmit(form, type)
{
    if (confirm('Êtes-vous sûr de vouloir supprimer '+ type+ ' ?'))
        {
        form.submit();
        }
};

function enlarge(pic)
{
    var url = pic.src;
    
    var parent = pic.parentNode;
    
    var newDiv = document.createElement('div');
    var newImg = document.createElement('img');
    
    newDiv.className = 'display';
    newDiv.setAttribute('onclick', 'shrink(this);');
    newImg.src = url;
    
    parent.insertBefore(newDiv, pic);
    newDiv.appendChild(newImg);
    setTimeout(function(){newImg.className = "transition";}, 1);
    
};

function shrink(div)
{
    var parent = div.parentNode;
    
    parent.removeChild(div);
};

function addOnClicks()
{
    var articles = document.getElementsByTagName("ARTICLE");
    for (var i = 0; i < articles.length; i++)
    {
       var img = articles[i].getElementsByTagName("IMG")
       for (var j = 0; j < img.length; j++)
       {
           img[j].setAttribute('onclick', 'enlarge(this);');
       }
    }
} 

function urlToLink()
{
    var comments = document.getElementsByClassName("comment");
    for (var i = 0; i < comments.length; i++)
    {
        var regex = /(https?:\/\/([a-zA-Z0-9-]+\.){2,}([a-zA-Z]{2,6})(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?)/g
        comments[i].innerHTML = comments[i].innerHTML.replace(regex, '<a href="$1">$1</a>');
    }
}

function init()
{
    addOnClicks();
    urlToLink();
}

window.onload = init;


            
            
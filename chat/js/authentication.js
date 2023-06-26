/**
 * \\Author: Thibault Napoléon "Imothep"
 * \\Company: ISEN Yncréa Ouest
 * \\Email: thibault.napoleon@isen-ouest.yncrea.fr
 * \\Created Date: 18-Apr-2023 - 17:13:38
 * \\Last Modified: 21-Apr-2023 - 11:08:45
 */

'use strict'

// Define callbacks.
document.getElementById('authentication-area').addEventListener('submit',
  setCookie);
connect();

//------------------------------------------------------------------------------
//--- connect ------------------------------------------------------------------
//------------------------------------------------------------------------------
// Function to connect the user.
function connect()
{  
  let cookie;
  
  cookie = document.cookie.split('; ').find(row => row.startsWith('auth='));
  if (cookie && cookie != 'auth=')
  {
    // Set expire date of login cookie if required.
    if (document.getElementById('stayconnected').checked)
      document.cookie = cookie + ';max-age=' + 60*60*24*7;
    
    // Redirect to chat page.
    window.location.href = 'chat.html';
  }
}

//------------------------------------------------------------------------------
//--- setCookie ----------------------------------------------------------------
//------------------------------------------------------------------------------
// Function to set the auth cookie.
// \param event The submit event.
function setCookie(event)
{
  event.preventDefault();
  
  // Store login in cookie if required.
  document.cookie = 'auth=' + btoa(document.getElementById('login').value +
    ':' + document.getElementById('password').value);
  connect();
}

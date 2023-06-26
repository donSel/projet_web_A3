/**
 * \\Author: Thibault Napoléon "Imothep"
 * \\Company: ISEN Yncréa Ouest
 * \\Email: thibault.napoleon@isen-ouest.yncrea.fr
 * \\Created Date: 18-Apr-2023 - 17:13:38
 * \\Last Modified: 21-Apr-2023 - 10:48:46
 */

'use strict'

let login;
let password;
var refreshInterval;

// Define callbacks.
document.getElementById('logout').addEventListener('click', logout);
document.getElementById('channels-list').addEventListener('change',
  getMessages);
document.getElementById('chat-area').addEventListener('submit', sendMessage);
document.getElementById('refresh-delay').addEventListener('input',
  manageRefresh);
getCookie();

//------------------------------------------------------------------------------
//--- getCookie ----------------------------------------------------------------
//------------------------------------------------------------------------------
// Function to get the user login/password and display a welcome message.
function getCookie()
{
  let cookie;

  cookie = document.cookie.split('; ').find(row => row.startsWith('auth='))
  cookie = atob(cookie.substring(5));
  login = cookie.substring(0, cookie.indexOf(':'));
  password = cookie.substring(cookie.indexOf(':') + 1);
  //alert('Bienvenue : ' + login);
  getChannels();
}

//------------------------------------------------------------------------------
//--- logout -------------------------------------------------------------------
//------------------------------------------------------------------------------
// Function to logout and redirect to authentication.
function logout()
{
  if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?'))
  {
    document.cookie = 'auth=';
    window.location.href = 'authentication.html';
  }
}

//------------------------------------------------------------------------------
//--- manageRefresh ------------------------------------------------------------
//------------------------------------------------------------------------------
// Mamange the resfresh interval.
function manageRefresh()
{
  let refreshValue;

  clearInterval(refreshInterval);
  refreshValue = parseInt(document.getElementById('refresh-delay').value);
  if (!isNaN(refreshValue) && refreshValue != 0)
    refreshInterval = setInterval(getMessages, refreshValue*1000);
}

//------------------------------------------------------------------------------
//--- getChannels --------------------------------------------------------------
//------------------------------------------------------------------------------
// Get the channels from the server.
function getChannels()
{
  ajaxRequest('GET', 'php/chat.php?request=channels', displayChannels);
}

//------------------------------------------------------------------------------
//--- getMessages --------------------------------------------------------------
//------------------------------------------------------------------------------
// Get the messages from the server.
function getMessages()
{
  let channelId;

  // Get current channel Id.
  channelId = document.getElementById('channels-list').value;

  // Get the messages from the server for the specified channel.
  ajaxRequest('GET', 'php/chat.php?request=messages&channel_id=' + channelId,
    displayMessages);
}

//------------------------------------------------------------------------------
//--- sendMessage --------------------------------------------------------------
//------------------------------------------------------------------------------
// Send a message to the server.
// \param event The click event.
function sendMessage(event)
{
  let channels;
  let channelId;
  let message;

  event.preventDefault();

  // Get current channel Id.
  channels = document.getElementById('channels-list');
  channelId = channels.options[channels.selectedIndex].value;

  // Send new message to the server to the specified channel.
  message = document.getElementById('message').value;
  document.getElementById('message').value = '';
  ajaxRequest('POST', 'php/chat.php?request=messages', getMessages,
    'channel_id=' + channelId + '&message=' + message + '&login=' + login);
}

//------------------------------------------------------------------------------
//--- displayChannels ----------------------------------------------------------
//------------------------------------------------------------------------------
// Display the channels in the combo box.
// \param channels The channels list.
function displayChannels(channels)
{
  let text;

  // Fill the channels list.
  text = '';
  for (let channel of channels)
    text += '<option value=' + channel.id + '>' + channel.name + '</option>';
  document.getElementById('channels-list').innerHTML = text;

  // Get messages for the current channel.
  getMessages();
}

//------------------------------------------------------------------------------
//--- displayMessages ----------------------------------------------------------
//------------------------------------------------------------------------------
// Display the messages in the chat.
// \param messages The messages list.
function displayMessages(messages)
{
  let chatRoom;
  let text;

  // Fill the chat room with the messages.
  text = '';
  // for (let i = messages.length - 1; i >= 0; i--)
  //   text += messages[i].nickname + ' : ' + messages[i].message + '<br>';
  // document.getElementById('chat-room-inject').innerHTML = text;
  for (let i = messages.length - 1; i >= 0; i--)
    text += messages[i].nickname + ' : ' + messages[i].message + '\n';
  chatRoom = document.getElementById('chat-room');
  chatRoom.innerHTML = text;
  chatRoom.scrollTop = chatRoom.scrollHeight;
}

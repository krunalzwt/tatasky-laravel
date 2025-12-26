<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Channel</title>

    <link href="{{ asset('app.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div id="wrapper">
        <!-- header part -->
        <div id="headerpart">
            <div class="logo"><img src="{{ asset('img/logo.jpg') }}" width="150" alt="" /></div>
            <div class="header_right">
                <div class="headertitle">Admin Panel - Tata Sky</div>
                <div class="headerdate">{{ new DateTime()->format('d-m-Y') }}</div>
            </div>
            <div class="clear">
                <!-- -->
            </div>
        </div>
        <!-- //header part -->
        <!-- body part -->
        <div id="bodypart">
            <div><img src="{{ asset('img/bodytop.gif') }}" width="900" height="20" alt="" /></div>
            <div class="midbody">
                <!-- left part -->
                <div class="leftpart">
                    <div class="left_title">List of Channels</div>
                    <div>
                        <form action="{{ route('channels.delete') }}" method="post">
                            @csrf
                            <ul class="leftlist">
                                <li class="delete">
                                    <input class="floatl" name="selectAll" type="checkbox" id="selectAll"
                                        onchange="toggleAll()" />
                                    <input class="delet_button" value=" " name="delete" type="submit" />
                                    <div class="clear"><!-- --> </div>
                                </li>
                                <li>&nbsp;</li>
                                <li>
                                    <div class="div1">&nbsp;</div>
                                    <div class="div2"><b>Channel Name</b></div>
                                    <div class="div3"><b>Channel No.</b></div>
                                    <div class="clear"><!-- --></div>
                                </li>
                                @foreach ($allChannels as $channelItem)
                                    <li>
                                        <div class="div1">
                                            <input class="checkbox floatl channel-checkbox" name="channels[]"
                                                type="checkbox" value="{{ $channelItem->id }}" />
                                        </div>
                                        <div class="div2">
                                            <a href="{{ route('channels.edit', $channelItem->id) }}">{{ $channelItem->name }}</a>
                                        </div>
                                        <div class="div3">{{ $channelItem->number }}</div>
                                        <div class="clear"><!-- --></div>
                                    </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                </div>
                <!-- //left part -->
                <!-- right part -->
                <div class="rightpart">
                    <div class="rightform">
                        <div>
                            <div class="floatl">
                                <h1>Add New Channel</h1>
                            </div>
                            <div class="floatr redtxt">All fields marked with (*) are required</div>
                            <div class="clear"><!-- --></div>
                        </div>
                        <form method="post" action="{{ route('channels.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label>Channel Name : <span class="redtxt">*</span></label>
                                <input class="inputbox_long" name="name" type="text"
                                    value="{{ old('name') }}" />
                                <div class="sidetxt">It must be unique in DB</div>
                                <div class="clear"><!-- --></div>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label>Channel Number : <span class="redtxt">*</span></label>
                                <select style="padding: 5px;" name="number">
                                    <option value="{{ old('number') }}">Select Number:</option>
                                    @for ($i = 100; $i <= 500; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="sidetxt">It must be unique in DB.</div>
                                <div class="clear"><!-- --></div>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <label>Logo : <span class="redtxt">*</span></label>
                                <input type="file" name="logo_path" accept="image/*" />
                                <div class="sidetxt">* It must be file type image.</div>
                                <div class="clear"><!-- --></div>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <label>Description : <span class="redtxt">*</span></label>
                                <textarea class="textarea" name="description" cols="" rows="" maxlength="500">{{ old('description') }}</textarea>
                                <div class="sidetxt">(Max 500 chars)</div>
                                <div class="clear"><!-- --></div>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <label>Contact Email : <span class="redtxt">*</span></label>
                                <input type="email" name="email" class="inputbox_long"
                                    value="{{ old('email') }}" />
                                <div class="sidetxt">* Valid email address.</div>
                                <div class="clear"><!-- --></div>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label>Contact Number : <span class="redtxt">*</span></label>
                                <input type="number" name="contact_number" class="inputbox_long"
                                    value="{{ old('contact_number') }}" />
                                <div class="sidetxt">* Digits only.</div>
                                <div class="clear"><!-- --></div>
                            </div>
                            <div>
                                <label>&nbsp;</label>
                                <input class="submit_button" value="Add Channel" name="submit" type="submit" />
                                <div class="clear"><!-- --></div>
                            </div>
                        </form>

                        @if (session('success'))
                            <div class="success-message" style="color: green; margin-top: 10px; font-weight: bold;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="error-message" style="color: red; margin-top: 10px;">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- //right part -->
                <div class="clear"><!-- --></div>
            </div>
            <div><img src="{{ asset('img/bodybot.gif') }}" width="900" height="20" /></div>
        </div>
        <!-- //body part -->
    </div>
</body>

</html>

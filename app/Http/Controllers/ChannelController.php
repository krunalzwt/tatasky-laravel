<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChannelModel;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    public function view_create()
    {
        try {
            $allChannels = ChannelModel::all();
            return view('create-channel', compact('allChannels'));
        } catch (\Exception $e) {
            $allChannels = collect();
            return view('create-channel', compact('allChannels'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:channels,name',
            'number' => 'required|unique:channels,number|integer|min:1|max:500',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|max:500',
            'email'=>'required|email',
            'contact_number'=>'required|regex:/^[0-9]{10}$/'
        ]);

        $filePath = null;
        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            try {
                $filePath = $file->storeAs('uploads/channels', $filename, 'public');
            } catch (\Exception $e) {
                return back()->withErrors(['logo_path' => 'File upload failed: ' . $e->getMessage()])->withInput();
            }
        }

        try{
            $channel = new ChannelModel();
            $channel->name = $request->input('name');
            $channel->number = $request->input('number');
            $channel->description = $request->input('description');
            $channel->email = $request->input('email');         
            $channel->contact_number = $request->input('contact_number');         
            $channel->logo_path = $filePath;
            $channel->save();
        }catch(\Exception $e){
            return back()->withErrors(['db_error' => 'Database error: ' . $e->getMessage()])->withInput();
        }

        return redirect('/create-channel')->with('success', 'Channel created successfully!');
    }

    public function view_edit($id)
    {
        try {
            $channel = ChannelModel::findOrFail($id);
            $allChannels = ChannelModel::all();
            return view('edit-channel', compact('channel', 'allChannels'));
        } catch (\Exception $e) {
            return redirect('/create-channel')->withErrors(['error' => 'Channel not found']);
        }
    }

    public function update(Request $request, $id)
    {
        $channel = ChannelModel::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|unique:channels,name,' . $id,
            'number' => 'required|unique:channels,number,' . $id . '|integer|min:1|max:500',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|max:500',
            'email'=>'required|email',
            'contact_number'=>'required|regex:/^[0-9]{10}$/'
        ]);

        $filePath = $channel->logo_path;
        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            try {
                $filePath = $file->storeAs('uploads/channels', $filename, 'public');
                if( $channel->logo_path ){
                    Storage::disk('public')->delete($channel->logo_path);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['logo_path' => 'File upload failed: ' . $e->getMessage()])->withInput();
            }
        }

        try{
            $channel->name = $request->input('name');
            $channel->number = $request->input('number');
            $channel->description = $request->input('description');
            $channel->email = $request->input('email');         
            $channel->contact_number = $request->input('contact_number');         
            $channel->logo_path = $filePath;
            $channel->save();
        }catch(\Exception $e){
            return back()->withErrors(['db_error' => 'Database error: ' . $e->getMessage()])->withInput();
        }

        return redirect('/edit-channel/' . $id)->with('success', 'Channel updated successfully!');
    }

    public function delete(Request $request)
    {
        try {
            $channelIds = $request->input('channels', []);
            
            if (empty($channelIds)) {
                return redirect()->back()->withErrors(['error' => 'No channels selected for deletion.']);
            }

            $channels = ChannelModel::whereIn('id', $channelIds)->get();
            
            foreach ($channels as $channel) {
                if ($channel->logo_path) {
                    Storage::disk('public')->delete($channel->logo_path);
                }
                $channel->delete();
            }
            

            return redirect('/create-channel');
        } catch (\Exception $e) {
            return redirect('/create-channel')->withErrors(['error' => 'Deletion failed: ' . $e->getMessage()]);
        }
    }
}

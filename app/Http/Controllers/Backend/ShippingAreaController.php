<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShipDistrict;
use App\Models\ShipDivision;
use App\Models\ShipState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShippingAreaController extends Controller
{
    // Division controller
    public function AllDivision()
    {
        $divisions = ShipDivision::latest()->get();
        return view('backend.shipping.division.all_division', compact('divisions'));
    }

    public function StoreDivision(Request $request)
    {
        $request->validate([
            'division_name' => 'required|string|max:255|unique:ship_divisions,division_name',
        ], [
            'division_name.unique' => 'The division name has already been taken.',
        ]);

        ShipDivision::create([
            'division_name' => $request->division_name,
        ]);

        return redirect()->route('all.division')->with([
            'message' => 'Division added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function UpdateDivision(Request $request, $id)
    {
        $request->validate([
            'division_name' => 'required|string|max:255|unique:ship_divisions,division_name,' . $id,
        ], [
            'division_name.unique' => 'The division name has already been taken.',
        ]);

        $division = ShipDivision::findOrFail($id);
        $division->update([
            'division_name' => $request->division_name,
        ]);

        return redirect()->route('all.division')->with([
            'message' => 'Division updated successfully',
            'alert-type' => 'info',
        ]);
    }

    public function DeleteDivision($id)
    {
        ShipDivision::findOrFail($id)->delete();

        return redirect()->route('all.division')->with([
            'message' => 'Division deleted successfully',
            'alert-type' => 'success',
        ]);
    }


    // District controller
    public function AllDistricts()
    {
        $districts = ShipDistrict::latest()->get();
        $divisions = ShipDivision::all();
        return view('backend.shipping.district.all_district', compact('districts', 'divisions'));
    }

    public function StoreDistrict(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:ship_divisions,id',
            'district_name' => 'required|string|max:255|unique:ship_districts,district_name',
        ], [
            'district_name.unique' => 'The district name has already been taken.',
            'division_id.exists' => 'The selected division is invalid.',
        ]);

        ShipDistrict::create([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);

        return redirect()->route('all.district')->with([
            'message' => 'District added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function UpdateDistrict(Request $request, $id)
    {
        $request->validate([
            'division_id' => 'required|exists:ship_divisions,id',
            'district_name' => 'required|string|max:255|unique:ship_districts,district_name,' . $id,
        ], [
            'district_name.unique' => 'The district name has already been taken.',
            'division_id.exists' => 'The selected division is invalid.',
        ]);

        $district = ShipDistrict::findOrFail($id);
        $district->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);

        return redirect()->route('all.district')->with([
            'message' => 'District updated successfully',
            'alert-type' => 'info',
        ]);
    }

    public function DeleteDistrict($id)
    {
        $district = ShipDistrict::findOrFail($id);
        $district->delete();

        return redirect()->route('all.district')->with([
            'message' => 'District deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    // State controller
    public function AllState()
    {
        $states = ShipState::latest()->get();
        $divisions = ShipDivision::all();
        $districts = ShipDistrict::all();
        return view('backend.shipping.state.all_state', compact('states', 'divisions', 'districts'));
    }

    // StateController.php
    public function getDistricts($division_id)
    {
        $districts = ShipDistrict::where('division_id', $division_id)->get();
        return response()->json(['districts' => $districts]);
    }

    public function StoreState(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:ship_divisions,id',
            'district_id' => 'required|exists:ship_districts,id',
            'state_name' => 'required|string|max:255|unique:ship_states,state_name',
        ], [
            'state_name.unique' => 'The state name has already been taken.',
            'division_id.exists' => 'The selected division is invalid.',
            'district_id.exists' => 'The selected district is invalid.',
        ]);

        ShipState::create([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
        ]);

        return redirect()->route('all.state')->with([
            'message' => 'State added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function UpdateState(Request $request, $id)
    {
        $request->validate([
            'division_id' => 'required|exists:ship_divisions,id',
            'district_id' => 'required|exists:ship_districts,id',
            'state_name' => 'required|string|max:255|unique:ship_states,state_name,' . $id,
        ], [
            'state_name.unique' => 'The state name has already been taken.',
            'division_id.exists' => 'The selected division is invalid.',
            'district_id.exists' => 'The selected district is invalid.',
        ]);

        $state = ShipState::findOrFail($id);
        $state->update([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
        ]);

        return redirect()->route('all.state')->with([
            'message' => 'State updated successfully',
            'alert-type' => 'info',
        ]);
    }

    public function DeleteState($id)
    {
        $state = ShipState::findOrFail($id);
        $state->delete();

        return redirect()->route('all.state')->with([
            'message' => 'State deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    public function getStates($district_id)
    {
        $states = ShipState::where('district_id', $district_id)->get();
        return response()->json(['states' => $states]);
    }
}

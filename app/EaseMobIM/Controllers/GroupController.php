<?php



namespace Genv\Otc\EaseMobIm;

use GuzzleHttp\Client;
use Genv\Otc\Models\User;
use Illuminate\Http\Request;
use Genv\Otc\Models\ImGroup;
use Genv\Otc\Models\FileWith;

class GroupController extends EaseMobController
{
    /**
     * 创建群组.
     *
     * @param CheckGroup $request
     * @param ImGroup $imGroup
     * @author ZsyD<1251992018@qq.com>
     * @return $this
     */
    public function store(CheckGroup $request, ImGroup $imGroup)
    {
        $callback = function () use ($request, $imGroup) {
            $options['groupname'] = $request->input('groupname');
            $options['desc'] = $request->input('desc');
            $options['public'] = (bool) $request->input('public', 1);
            $options['maxusers'] = $request->input('maxusers', 300);
            $options['members_only'] = (bool) $request->input('members_only', 0);
            $options['allowinvites'] = (bool) $request->input('allowinvites', 1);
            $options['owner'] = (string) $request->user()->id;
            $request->input('members') && $options['members'] = $request->input('members');

            $url = $this->url.'chatgroups';
            $data['headers'] = [
                'Authorization' => $this->getToken(),
            ];
            $data['body'] = json_encode($options);
            $data['http_errors'] = false;
            $Client = new Client();
            $result = $Client->request('post', $url, $data);

            if ($result->getStatusCode() != 200) {
                $error = $result->getBody()->getContents();

                return response()->json([
                    'message' => [
                        json_decode($error)->error_description,
                    ],
                ])->setStatusCode(500);
            }
            $res = json_decode($result->getBody()->getContents());

            $imGroup->im_group_id = $res->data->groupid;
            $imGroup->user_id = $request->user()->id;
            $imGroup->group_face = $request->input('group_face', 0);
            $imGroup->type = $request->input('type', 0);

            // 创建头像
            $fileWith = FileWith::where('id', $imGroup->group_face)
                ->where('channel', null)
                ->where('raw', null)
                ->first();

            if (! $imGroup->save()) {
                return response()->json([
                    'message' => ['创建失败'],
                    'group_id' => $res->error_description,
                ])->setStatusCode(500);
            }
            // 保存群头像
            $fileWith->channel = 'im:group_face';
            $fileWith->raw = $imGroup->id;
            $fileWith->save();

            // 发送消息至群组
            $cmd_content = $request->user()->name.'创建了群聊！';
            $isCmd = $this->sendCmd($cmd_content, [$imGroup->im_group_id]);

            if (! $isCmd) {
                return response()->json([
                    'message' => ['消息发送失败'],
                    'im_group_id' => $imGroup->im_group_id,
                ])->setStatusCode(202);
            }

            return response()->json([
                'message' => ['成功'],
                'im_group_id' => $imGroup->im_group_id,
            ])->setStatusCode(201);
        };

        return $this->getConfig($callback);
    }

    /**
     * 修改群信息.
     *
     * @param UpdateGroup $request
     * @return $this
     * @author ZsyD<1251992018@qq.com>
     */
    public function update(UpdateGroup $request)
    {
        $callback = function () use ($request) {
            $im_group_id = $request->input('im_group_id');
            $options['groupname'] = $request->input('groupname');
            $options['desc'] = $request->input('desc');
            $options['public'] = (bool) $request->input('public', 1);
            $options['maxusers'] = $request->input('maxusers', 300);
            $options['members_only'] = (bool) $request->input('members_only', 0);
            $options['allowinvites'] = (bool) $request->input('allowinvites', 1);

            $url = $this->url.'chatgroups/'.$im_group_id;
            $data['headers'] = [
                'Authorization' => $this->getToken(),
            ];
            $data['body'] = json_encode($options);
            $data['http_errors'] = false;
            $Client = new Client();
            $result = $Client->request('put', $url, $data);

            if ($result->getStatusCode() != 200) {
                $error = $result->getBody()->getContents();

                return response()->json([
                    'message' => [
                        json_decode($error)->error_description,
                    ],
                ])->setStatusCode(500);
            }

            $imGroup = ImGroup::where('im_group_id', $im_group_id)->first();
            $imGroup->group_face = $request->input('group_face', 0);
            $imGroup->type = $request->input('type', 0);

            // 创建头像
            $fileWith = FileWith::where('id', $imGroup->group_face)
                ->where('channel', null)
                ->where('raw', null)
                ->first();

            if (! $imGroup->save()) {
                return response()->json([
                    'message' => ['修改失败'],
                    'group_id' => $im_group_id,
                ])->setStatusCode(500);
            }
            // 保存群头像
            if ($fileWith) {
                $fileWith->channel = 'im:group_face';
                $fileWith->raw = $imGroup->id;
                $fileWith->save();
            }

            // 发送消息至群组
            $cmd_content = $request->user()->name.'修改了群信息！';
            $isCmd = $this->sendCmd($cmd_content, [$im_group_id]);

            if (! $isCmd) {
                return response()->json([
                    'message' => ['消息发送失败'],
                    'im_group_id' => $im_group_id,
                ])->setStatusCode(202);
            }

            return response()->json([
                'message' => ['成功'],
                'im_group_id' => $im_group_id,
            ])->setStatusCode(201);
        };

        return $this->getConfig($callback);
    }

    /**
     * 删除群组.
     *
     * @param Request $request
     * @param ImGroup $imGroup
     * @return $this
     * @author ZsyD<1251992018@qq.com>
     */
    public function delete(Request $request, ImGroup $imGroup)
    {
        $callback = function () use ($request, $imGroup) {
            $im_group_id = $request->query('im_group_id');
            $group = $imGroup->where('user_id', $request->user()->id)
                ->where('im_group_id', $im_group_id);

            if (! $group->first()) {
                return response()->json([
                    'message' => ['该群组不存在或已被删除'],
                ])->setStatusCode(400);
            }

            $url = $this->url.'chatgroups/'.$im_group_id;
            $data['headers'] = [
                'Authorization' => $this->getToken(),
            ];
            $data['http_errors'] = false;
            $Client = new Client();
            $result = $Client->request('delete', $url, $data);

            if ($result->getStatusCode() != 200) {
                $error = $result->getBody()->getContents();

                return response()->json([
                    'message' => [
                        json_decode($error)->error_description,
                    ],
                ])->setStatusCode(500);
            }

            $group->delete();

            return response()->json([
                'message' => ['成功'],
            ])->setStatusCode(204);
        };

        return $this->getConfig($callback);
    }

    /**
     * 获取群信息.
     *
     * @param Request $request
     * @return $this
     * @author ZsyD<1251992018@qq.com>
     */
    public function getGroup(Request $request)
    {
        $callback = function () use ($request) {
            $im_group_id = $request->query('im_group_id'); // 多个以“,”隔开
            $url = $this->url.'chatgroups/'.$im_group_id;
            $data['headers'] = [
                'Authorization' => $this->getToken(),
            ];
            $data['http_errors'] = false;
            $Client = new Client();
            $result = $Client->request('get', $url, $data);
            $groupCon = json_decode($result->getBody()->getContents());

            if ($result->getStatusCode() != 200) {
                return response()->json([
                    'message' => [
                        $groupCon->error_description,
                    ],
                ])->setStatusCode(500);
            }

            foreach ($groupCon->data as $key => &$group) {
                $affiliations = collect($group->affiliations);
                $owner = $affiliations->pluck('owner')->filter();
                $members = $affiliations->pluck('member')->filter();
                $group->affiliations = $this->getUser($members, $owner);
            }

            return response()->json([
                'message' => ['获取成功'],
                'im_groups' => $groupCon->data,
            ])->setStatusCode(200);
        };

        return $this->getConfig($callback);
    }

    /**
     * 获取群头像(多个用","隔开).
     *
     * @param GroupId $request
     * @return \Illuminate\Http\JsonResponse
     * @author ZsyD<1251992018@qq.com>
     */
    public function getGroupFace(GroupId $request)
    {
        $groups = $request->input('im_group_id');
        $groups = ! is_array($groups) ? explode(',', $groups) : $groups;
        $datas = ImGroup::whereIn('im_group_id', $groups)
            ->select('im_group_id', 'group_face')
            ->get();

        return response()->json($datas, 200);
    }

    /**
     * 获取群组用户信息列表.
     *
     * @param $members
     * @param $owner
     * @return mixed
     * @author ZsyD<1251992018@qq.com>
     */
    private function getUser($members, $owner)
    {
        $users = User::whereIn('id', $owner->merge($members))->get();
        $admin = $owner->values()[0];
        if ($users) {
            $users->map(function ($user) use ($admin) {
                $user->is_owner = $user->id == $admin ? 1 : 0;

                return $user;
            });
        }

        return $users;
    }

    /**
     * 添加群成员(多个用","隔开).
     *
     * @param GroupMember $request
     * @return $this
     * @author ZsyD<1251992018@qq.com>
     */
    public function addGroupMembers(GroupMember $request)
    {
        $callback = function () use ($request) {
            $im_group_id = $request->input('im_group_id');
            $option['usernames'] = $request->input('members');
            $option['usernames'] = is_array($option['usernames']) ? $option['usernames'] : explode(',', $option['usernames']);

            // 查询用户昵称
            $users = User::whereIn('id', $option['usernames'])->pluck('name');
            $names = '';
            if ($users) {
                $names = implode('、', $users->toArray());
            }
            $url = $this->url.'chatgroups/'.$im_group_id.'/users';
            $data['body'] = json_encode($option);
            $data['headers'] = [
                'Authorization' => $this->getToken(),
            ];
            $data['http_errors'] = false;
            $Client = new Client();
            $result = $Client->request('post', $url, $data);
            $groupCon = json_decode($result->getBody()->getContents());

            if ($result->getStatusCode() != 200) {
                return response()->json([
                    'message' => [
                        $groupCon->error_description,
                    ],
                ])->setStatusCode(500);
            }
            // 发送消息至群组
            $cmd_content = $request->user()->name.'邀请了'.$names.'加入了群聊。';
            $isCmd = $this->sendCmd($cmd_content, [$im_group_id]);

            if (! $isCmd) {
                return response()->json([
                    'message' => ['消息发送失败'],
                    'im_group_id' => $im_group_id,
                ])->setStatusCode(202);
            }

            return response()->json([])->setStatusCode(201);
        };

        return $this->getConfig($callback);
    }

    /**
     * 移除群成员(多个用","隔开).
     *
     * @param GroupMember $request
     * @return $this
     * @author ZsyD<1251992018@qq.com>
     */
    public function removeGroupMembers(GroupMember $request)
    {
        $callback = function () use ($request) {
            $im_group_id = $request->input('im_group_id');
            $members = $request->input('members');
            $members = is_array($members) ? implode(',', $members) : $members;
            // 查询用户昵称
            $users = User::whereIn('id', explode(',', $members))->pluck('name');
            $names = '';
            if ($users) {
                $names = implode('、', $users->toArray());
            }

            $url = $this->url.'chatgroups/'.$im_group_id.'/users/'.$members;
            $data['headers'] = [
                'Authorization' => $this->getToken(),
            ];
            $data['http_errors'] = false;
            $Client = new Client();
            $result = $Client->request('delete', $url, $data);
            $groupCon = json_decode($result->getBody()->getContents());

            if ($result->getStatusCode() != 200) {
                return response()->json([
                    'message' => [
                        $groupCon->error_description,
                    ],
                ])->setStatusCode(500);
            }
            // 发送消息至群组
            $cmd_content = $request->user()->name.'已将'.$names.'移出群聊。';
            $isCmd = $this->sendCmd($cmd_content, [$im_group_id]);

            if (! $isCmd) {
                return response()->json([
                    'message' => ['消息发送失败'],
                    'im_group_id' => $im_group_id,
                ])->setStatusCode(202);
            }

            return response()->json([])->setStatusCode(204);
        };

        return $this->getConfig($callback);
    }
}

# 一个小小的 LearnKu 克隆

lk 是一个论坛程序，灵感来自 LearnKu，功能有：

- 用户账户：用户可以通过用户名密码注册登录，也可以通过 GitHub 注册登录；
- 社区讨论：用户可以新建和编辑分类（分区），分类下可以新增主题，主题下可以评论；
- 互动功能：用户可以把帖子、评论标记为喜爱，其作者会收到别人喜爱的通知。

LearnKu 有很多论坛讨论之外的功能，比如社交和课程，这些功能我没有考虑。

## 技术栈

- Laravel
- Tailwind CSS

网站前端是 JavaScript Free 的，只有两处小功能用到了 JavaScript：

- Markdown 编辑器上传图片时，需要用 JavaScript 监听拖拽、粘贴事件；
- Markdown 编辑器上的【编辑】和【预览】切换，用到了 Alpine.js
- 回复别人的评论时，Toggle 评论表单，用到了 Alpine.js

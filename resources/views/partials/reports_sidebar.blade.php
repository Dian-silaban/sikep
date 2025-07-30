import React, { useState, useEffect } from 'react';

// Main App component
const App = () => {
  // State to manage sidebar visibility on mobile
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);
  // State to manage the active menu item
  const [activeMenuItem, setActiveMenuItem] = useState('dashboard');

  // Function to toggle sidebar visibility
  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  // Effect to close sidebar when screen size changes (e.g., from mobile to desktop)
  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth >= 768) { // md breakpoint in Tailwind CSS
        setIsSidebarOpen(false); // Close sidebar if it's open on larger screens
      }
    };
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  // Function to render content based on active menu item
  const renderContent = () => {
    switch (activeMenuItem) {
      case 'dashboard':
        return (
          <div className="p-6">
            <h2 className="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>
            <p className="text-gray-600">Selamat datang di Dashboard Buku Jaga Usulan Anda. Di sini Anda bisa melihat ringkasan data penting.</p>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
              <div className="bg-white p-6 rounded-lg shadow-md">
                <h3 className="text-lg font-medium text-gray-700 mb-2">Total Usulan</h3>
                <p className="text-3xl font-bold text-indigo-600">125</p>
              </div>
              <div className="bg-white p-6 rounded-lg shadow-md">
                <h3 className="text-lg font-medium text-gray-700 mb-2">Usulan Baru</h3>
                <p className="text-3xl font-bold text-green-600">15</p>
              </div>
              <div className="bg-white p-6 rounded-lg shadow-md">
                <h3 className="text-lg font-medium text-gray-700 mb-2">Usulan Selesai</h3>
                <p className="text-3xl font-bold text-red-600">90</p>
              </div>
            </div>
          </div>
        );
      case 'usulan-baru':
        return (
          <div className="p-6">
            <h2 className="text-2xl font-semibold text-gray-800 mb-4">Usulan Baru</h2>
            <p className="text-gray-600">Di sini Anda dapat menambahkan usulan baru.</p>
            <div className="bg-white p-6 rounded-lg shadow-md mt-6">
              <form>
                <div className="mb-4">
                  <label htmlFor="judul" className="block text-gray-700 text-sm font-bold mb-2">Judul Usulan:</label>
                  <input type="text" id="judul" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan judul usulan" />
                </div>
                <div className="mb-4">
                  <label htmlFor="deskripsi" className="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                  <textarea id="deskripsi" rows="5" className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Jelaskan detail usulan Anda"></textarea>
                </div>
                <div className="flex items-center justify-between">
                  <button type="submit" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Simpan Usulan
                  </button>
                </div>
              </form>
            </div>
          </div>
        );
      case 'daftar-usulan':
        return (
          <div className="p-6">
            <h2 className="text-2xl font-semibold text-gray-800 mb-4">Daftar Usulan</h2>
            <p className="text-gray-600">Berikut adalah daftar semua usulan yang ada.</p>
            <div className="bg-white p-6 rounded-lg shadow-md mt-6">
              <table className="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                <thead className="bg-gray-50">
                  <tr>
                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  <tr>
                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Peningkatan Sistem Absensi</td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm text-yellow-500">Pending</td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-10-26</td>
                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <button className="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                      <button className="text-red-600 hover:text-red-900">Hapus</button>
                    </td>
                  </tr>
                  <tr>
                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pengadaan Peralatan Kantor Baru</td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm text-green-500">Selesai</td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-10-20</td>
                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <button className="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                      <button className="text-red-600 hover:text-red-900">Hapus</button>
                    </td>
                  </tr>
                  <tr>
                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Revisi Prosedur Pengajuan Cuti</td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm text-yellow-500">Pending</td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-10-18</td>
                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <button className="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                      <button className="text-red-600 hover:text-red-900">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        );
      case 'pengaturan':
        return (
          <div className="p-6">
            <h2 className="text-2xl font-semibold text-gray-800 mb-4">Pengaturan</h2>
            <p className="text-gray-600">Di sini Anda dapat mengelola pengaturan aplikasi.</p>
            <div className="bg-white p-6 rounded-lg shadow-md mt-6">
              <p className="text-gray-700">Opsi pengaturan akan ditambahkan di sini.</p>
            </div>
          </div>
        );
      default:
        return null;
    }
  };

  return (
    // Main container for the application
    <div className="flex h-screen bg-gray-100 font-sans">
      {/* Tailwind CSS CDN for styling */}
      <script src="https://cdn.tailwindcss.com"></script>
      {/* Font Inter for better typography */}
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
      <style>
        {`
          body {
            font-family: 'Inter', sans-serif;
          }
          /* Custom styles for sidebar transition */
          .sidebar-transition {
            transition: transform 0.3s ease-in-out;
          }
          .sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40; /* Below sidebar, above content */
          }
        `}
      </style>

      {/* Mobile menu button */}
      <div className="md:hidden fixed top-0 left-0 z-50 p-4">
        <button
          onClick={toggleSidebar}
          className="text-gray-700 focus:outline-none focus:text-gray-900"
        >
          {/* Hamburger icon */}
          <svg
            className="h-6 w-6"
            fill="none"
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            {isSidebarOpen ? (
              <path d="M6 18L18 6M6 6l12 12" /> // Close icon (X)
            ) : (
              <path d="M4 6h16M4 12h16M4 18h16" /> // Hamburger icon
            )}
          </svg>
        </button>
      </div>

      {/* Sidebar overlay for mobile */}
      {isSidebarOpen && (
        <div
          className="fixed inset-0 sidebar-overlay md:hidden"
          onClick={toggleSidebar} // Close sidebar when clicking outside
        ></div>
      )}

      {/* Sidebar */}
      <aside
        className={`fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50
          transform ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'}
          md:relative md:translate-x-0 sidebar-transition md:flex md:flex-col`}
      >
        <div className="flex items-center justify-center h-16 bg-indigo-600 text-white text-2xl font-bold rounded-tr-lg">
          Buku Jaga
        </div>
        <nav className="flex-1 px-2 py-4 space-y-2">
          {/* Dashboard Link */}
          <button
            onClick={() => {
              setActiveMenuItem('dashboard');
              setIsSidebarOpen(false); // Close sidebar on mobile after selection
            }}
            className={`w-full flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200 focus:outline-none
              ${activeMenuItem === 'dashboard' ? 'bg-indigo-100 text-indigo-700 font-medium' : ''}`}
          >
            <svg className="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
          </button>
          {/* Usulan Baru Link */}
          <button
            onClick={() => {
              setActiveMenuItem('usulan-baru');
              setIsSidebarOpen(false);
            }}
            className={`w-full flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200 focus:outline-none
              ${activeMenuItem === 'usulan-baru' ? 'bg-indigo-100 text-indigo-700 font-medium' : ''}`}
          >
            <svg className="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Usulan Baru
          </button>
          {/* Daftar Usulan Link */}
          <button
            onClick={() => {
              setActiveMenuItem('daftar-usulan');
              setIsSidebarOpen(false);
            }}
            className={`w-full flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200 focus:outline-none
              ${activeMenuItem === 'daftar-usulan' ? 'bg-indigo-100 text-indigo-700 font-medium' : ''}`}
          >
            <svg className="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Daftar Usulan
          </button>
          {/* Pengaturan Link */}
          <button
            onClick={() => {
              setActiveMenuItem('pengaturan');
              setIsSidebarOpen(false);
            }}
            className={`w-full flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200 focus:outline-none
              ${activeMenuItem === 'pengaturan' ? 'bg-indigo-100 text-indigo-700 font-medium' : ''}`}
          >
            <svg className="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Pengaturan
          </button>
        </nav>
      </aside>

      {/* Main content area */}
      <div className="flex-1 flex flex-col overflow-hidden">
        {/* Header */}
        <header className="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-6 rounded-bl-lg">
          <div className="flex items-center">
            {/* This button is only visible on medium and larger screens to provide a consistent look */}
            <button
              onClick={toggleSidebar}
              className="text-gray-500 focus:outline-none focus:text-gray-900 hidden md:block" // Hide on small screens, show on medium+
            >
              <svg
                className="h-6 w-6"
                fill="none"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                {/* Hamburger icon for desktop */}
                <path d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
            <h1 className="text-xl font-semibold text-gray-800 ml-4 md:ml-0">
              {activeMenuItem === 'dashboard' && 'Dashboard'}
              {activeMenuItem === 'usulan-baru' && 'Usulan Baru'}
              {activeMenuItem === 'daftar-usulan' && 'Daftar Usulan'}
              {activeMenuItem === 'pengaturan' && 'Pengaturan'}
            </h1>
          </div>
          <div className="flex items-center">
            <span className="text-gray-700 mr-4">Halo, Pengguna!</span>
            <img
              className="h-10 w-10 rounded-full object-cover"
              src="https://placehold.co/40x40/FF5733/FFFFFF?text=P" // Placeholder image for user profile
              alt="Profil Pengguna"
              onError={(e) => { e.target.onerror = null; e.target.src = "https://placehold.co/40x40/FF5733/FFFFFF?text=P"; }}
            />
          </div>
        </header>

        {/* Page content */}
        <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4">
          {renderContent()}
        </main>
      </div>
    </div>
  );
};

export default App;

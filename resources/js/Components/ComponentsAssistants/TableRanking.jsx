export default function TableRanking() {
  return (
    <div className="mt-5">
      {/* Kontainer scroll */}
      <div className="overflow-x-auto">
        <div className="max-h-[400px] overflow-y-auto border border-forestGreen rounded-md">
          <table className="min-w-full table-auto border-collapse">
            <thead>
              <tr className="bg-deepForestGreen text-md text-center text-white">
                <th className="py-2 px-7 border-b">Ranking</th>
                <th className="py-2 px-7 border-b">Nama</th>
                <th className="py-2 px-7 border-b">NIM</th>
                <th className="py-2 px-7 border-b">Nilai</th>
              </tr>
            </thead>
            <tbody className="bg-softIvory">
              <tr className="text-darkBrown">
                <td className="py-2 px-4 border-b text-center">1</td>
                <td className="py-2 px-4 border-b">John Doe</td>
                <td className="py-2 px-4 border-b text-center">1101223083</td>
                <td className="py-2 px-4 border-b text-center">95</td>
              </tr>
              <tr className="text-darkBrown">
                <td className="py-2 px-4 border-b text-center">2</td>
                <td className="py-2 px-4 border-b">Jane Smith</td>
                <td className="py-2 px-4 border-b text-center">1101223089</td>
                <td className="py-2 px-4 border-b text-center">88</td>
              </tr>
              <tr className="text-darkBrown">
                <td className="py-2 px-4 border-b text-center">3</td>
                <td className="py-2 px-4 border-b">Mark Johnson</td>
                <td className="py-2 px-4 border-b text-center">1101223079</td>
                <td className="py-2 px-4 border-b text-center">85</td>
              </tr>
             
              {Array.from({ length: 10 }).map((_, index) => (
                <tr key={index} className="text-darkBrown">
                  <td className="py-2 px-4 border-b text-center">{index + 4}</td>
                  <td className="py-2 px-4 border-b">Nama {index + 4}</td>
                  <td className="py-2 px-4 border-b text-center">11012230{70 + index}</td>
                  <td className="py-2 px-4 border-b text-center">{80 - index}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
